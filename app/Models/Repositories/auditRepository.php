<?php

namespace App\Models\Repositories;
use App\contracts\IAuditRepository;
use PDO;

class AuditRepository implements IAuditRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(string $tablaHistorial, array $data): bool
    {
        $columnas = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($c) => ':' . $c, array_keys($data)));

        $sql = "INSERT INTO {$tablaHistorial} ({$columnas}) VALUES ({$placeholders})";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($data);
    }

    public function getPrimaryKey(string $tabla): string
    {
        $base = str_replace('historial_', '', $tabla);
        return 'ID_Historial_' . ucfirst($base);
    }

    public function getHistorial(
        string $tabla,
        ?int $idAdmin = null,
        ?string $tipoCambio = null,
        ?string $desde = null,
        ?string $hasta = null
    ): array {
        $sql = "SELECT * FROM {$tabla} WHERE 1=1";
        $params = [];

        if ($idAdmin !== null) {
            $sql .= " AND ID_Admin = :admin";
            $params[':admin'] = $idAdmin;
        }

        if ($tipoCambio !== null) {
            $sql .= " AND Tipo_Cambio = :accion";
            $params[':accion'] = strtoupper($tipoCambio);
        }

        if ($desde !== null) {
            $sql .= " AND Fecha_Cambio >= :desde";
            $params[':desde'] = $desde . ' 00:00:00';
        }

        if ($hasta !== null) {
            $sql .= " AND Fecha_Cambio <= :hasta";
            $params[':hasta'] = $hasta . ' 23:59:59';
        }

        $sql .= " ORDER BY Fecha_Cambio DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un registro específico del historial usando la PK real.
     */
    public function getRegistro(string $tabla, int $id): ?array
    {
        $pk = $this->getPrimaryKey($tabla);

        $sql = "SELECT * FROM {$tabla} WHERE {$pk} = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}

