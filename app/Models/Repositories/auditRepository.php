<?php

namespace App\Models\Repositories;

use PDO;

class AuditRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Inserta un registro de auditoría en la tabla indicada.
     *
     * @param string $tablaHistorial  Nombre de la tabla de historial (ej: 'historial_prestamo')
     * @param array  $data            Datos a insertar (columnas => valores)
     */
    public function insert(string $tablaHistorial, array $data): bool
    {
        // Construir columnas y placeholders dinámicamente
        $columnas = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($c) => ':' . $c, array_keys($data)));

        $sql = "INSERT INTO {$tablaHistorial} ({$columnas}) VALUES ({$placeholders})";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($data);
    }
}
