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

    // app/Models/Repositories/AuditRepository.php

    public function getHistorialPaginado(
        string $tabla,
        int $pagina = 1,
        int $porPagina = 10,
        ?int $idAdmin = null,
        ?string $tipoCambio = null,
        ?string $desde = null,
        ?string $hasta = null
    ): array {
        $offset = ($pagina - 1) * $porPagina;
        
        // Construir WHERE
        $where = "1=1";
        $params = [];
        if ($idAdmin !== null) {
            $where .= " AND ID_Admin = :admin";
            $params[':admin'] = $idAdmin;
        }
        if ($tipoCambio !== null) {
            $where .= " AND Tipo_Cambio = :accion";
            $params[':accion'] = strtoupper($tipoCambio);
        }
        if ($desde !== null) {
            $where .= " AND Fecha_Cambio >= :desde";
            $params[':desde'] = $desde . ' 00:00:00';
        }
        if ($hasta !== null) {
            $where .= " AND Fecha_Cambio <= :hasta";
            $params[':hasta'] = $hasta . ' 23:59:59';
        }
        
        // Contar total
        $countSql = "SELECT COUNT(*) FROM {$tabla} WHERE {$where}";
        $stmtCount = $this->pdo->prepare($countSql);
        $stmtCount->execute($params);
        $total = (int) $stmtCount->fetchColumn();
        
        // Obtener datos paginados
        $sql = "SELECT * FROM {$tabla} WHERE {$where} ORDER BY Fecha_Cambio DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        if ($idAdmin !== null) $stmt->bindValue(':admin', $idAdmin);
        if ($tipoCambio !== null) $stmt->bindValue(':accion', strtoupper($tipoCambio));
        if ($desde !== null) $stmt->bindValue(':desde', $desde . ' 00:00:00');
        if ($hasta !== null) $stmt->bindValue(':hasta', $hasta . ' 23:59:59');
        $stmt->bindValue(':limit', $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'datos' => $rows,
            'total' => $total,
            'pagina' => $pagina,
            'porPagina' => $porPagina,
            'ultimaPagina' => ceil($total / $porPagina)
        ];
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

