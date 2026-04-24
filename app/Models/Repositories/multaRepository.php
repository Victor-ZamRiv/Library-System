<?php

namespace App\Models\Repositories;

use App\Core\BaseRepository;
use App\Contracts\IMultaRepository;
use App\Models\Entities\Multa;
use PDO;

class MultaRepository extends BaseRepository implements IMultaRepository
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, 'multas', 'ID_Multa');
    }

    /**
     * Inserta una nueva multa.
     */
    public function insert(Multa $multa): int
    {
        if ($multa->getIdMulta() !== null) {
            throw new \InvalidArgumentException("La multa ya tiene ID, no puede insertarse.");
        }

        $sql = "INSERT INTO {$this->table} 
                (ID_Prestamo, ID_Admin, Monto, Fecha_Cancelacion, Estado)
                VALUES (:idPrestamo, :idAdmin, :monto, :fechaCancelacion, :estado)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':idPrestamo'       => $multa->getIdPrestamo(),
            ':idAdmin'          => $multa->getIdAdmin(),
            ':monto'            => $multa->getMonto(),
            ':fechaCancelacion' => $multa->getFechaCancelacion(),
            ':estado'           => $multa->getEstado()
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Actualiza una multa existente.
     */
    public function update(Multa $multa): bool
    {
        $id = $multa->getIdMulta();
        if ($id === null) {
            throw new \InvalidArgumentException("No se puede actualizar una multa sin ID.");
        }

        $sql = "UPDATE {$this->table} SET
                    ID_Prestamo = :idPrestamo,
                    ID_Admin = :idAdmin,
                    Monto = :monto,
                    Fecha_Cancelacion = :fechaCancelacion,
                    Estado = :estado
                WHERE {$this->primaryKey} = :id";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idPrestamo'       => $multa->getIdPrestamo(),
            ':idAdmin'          => $multa->getIdAdmin(),
            ':monto'            => $multa->getMonto(),
            ':fechaCancelacion' => $multa->getFechaCancelacion(),
            ':estado'           => $multa->getEstado(),
            ':id'               => $id
        ]);
    }

    /**
     * Busca una multa por ID.
     */
    public function find(int $id): ?Multa
    {
        $row = $this->fetchById($id);
        return $row ? $this->mapToEntity($row) : null;
    }

    /**
     * Busca la multa asociada a un préstamo (normalmente solo una por préstamo).
     */
    public function findByPrestamo(int $idPrestamo): ?Multa
    {
        $sql = "SELECT * FROM {$this->table} WHERE ID_Prestamo = :idPrestamo LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idPrestamo' => $idPrestamo]);
        $row = $stmt->fetch();
        return $row ? $this->mapToEntity($row) : null;
    }

    /**
     * Obtiene todas las multas pendientes de un lector (a través de sus préstamos).
     * Útil para validar antes de permitir un nuevo préstamo.
     */
    public function findPendientesByLector(int $idLector): array
    {
        $sql = "SELECT m.* 
                FROM {$this->table} m
                JOIN prestamos p ON m.ID_Prestamo = p.ID_Prestamo
                WHERE p.ID_Lector = :idLector 
                AND m.Estado = 'Pendiente'
                ORDER BY m.ID_Multa DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idLector' => $idLector]);
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => $this->mapToEntity($row), $rows);
    }

    /**
     * Marca una multa como pagada, registrando la fecha de cancelación.
     */
    public function marcarPagada(int $idMulta, string $fechaCancelacion): bool
    {
        $sql = "UPDATE {$this->table} 
                SET Estado = 'Pagada', Fecha_Cancelacion = :fecha 
                WHERE {$this->primaryKey} = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':fecha' => $fechaCancelacion,
            ':id'    => $idMulta
        ]);
    }

    /**
     * Marca una multa como cancelada (por ejemplo, si se determina que no aplicaba).
     */
    public function marcarCancelada(int $idMulta): bool
    {
        $sql = "UPDATE {$this->table} 
                SET Estado = 'Cancelada' 
                WHERE {$this->primaryKey} = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $idMulta]);
    }

    /**
     * Mapea una fila de la BD a la entidad Multa.
     */
    protected function mapToEntity(array $row): object
    {
        return Multa::fromArray($row);
    }
}