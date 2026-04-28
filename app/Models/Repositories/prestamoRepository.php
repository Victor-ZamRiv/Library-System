<?php

namespace App\Models\Repositories;

use App\Core\BaseRepository;
use App\Contracts\IPrestamoRepository;
use App\Models\Entities\Prestamo;
use PDO;

class PrestamoRepository extends BaseRepository implements IPrestamoRepository
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, 'prestamos', 'ID_Prestamo');
    }

    //Inserta un nuevo préstamo.
    public function insert(Prestamo $prestamo): int
    {
        if ($prestamo->getIdPrestamo() !== null) {
            throw new \InvalidArgumentException("El préstamo ya tiene ID, no puede insertarse.");
        }

        $sql = "INSERT INTO {$this->table} 
                (ID_Lector, ID_Admin, Fecha_Entregado, Fecha_Recepcion_Estipulada, Fecha_Recepcion_Real, Estado_Entrega, Activo)
                VALUES (:idLector, :idAdmin, :fechaEntregado, :fechaEstipulada, :fechaReal, :estado, :activo)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':idLector'        => $prestamo->getIdLector(),
            ':idAdmin'         => $prestamo->getIdAdmin(),
            ':fechaEntregado'  => $prestamo->getFechaEntregado(),
            ':fechaEstipulada' => $prestamo->getFechaRecepcionEstipulada(),
            ':fechaReal'       => $prestamo->getFechaRecepcionReal(),
            ':estado'          => $prestamo->getEstadoEntrega(),
            ':activo'          => $prestamo->getActivo() ? 1 : 0
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    //Actualiza un préstamo existente.

    public function update(Prestamo $prestamo): bool
    {
        $id = $prestamo->getIdPrestamo();
        if ($id === null) {
            throw new \InvalidArgumentException("No se puede actualizar un préstamo sin ID.");
        }

        $sql = "UPDATE {$this->table} SET
                    ID_Lector = :idLector,
                    ID_Admin = :idAdmin,
                    Fecha_Entregado = :fechaEntregado,
                    Fecha_Recepcion_Estipulada = :fechaEstipulada,
                    Fecha_Recepcion_Real = :fechaReal,
                    Estado_Entrega = :estado,
                    Activo = :activo
                WHERE {$this->primaryKey} = :id";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idLector'        => $prestamo->getIdLector(),
            ':idAdmin'         => $prestamo->getIdAdmin(),
            ':fechaEntregado'  => $prestamo->getFechaEntregado(),
            ':fechaEstipulada' => $prestamo->getFechaRecepcionEstipulada(),
            ':fechaReal'       => $prestamo->getFechaRecepcionReal(),
            ':estado'          => $prestamo->getEstadoEntrega(),
            ':activo'          => $prestamo->getActivo() ? 1 : 0,
            ':id'              => $id
        ]);
    }

    //Métodos de busqueda.
    
    public function find(int $id): ?Prestamo
    {
        $row = $this->fetchById($id);
        return $row ? $this->mapToEntity($row) : null;
    }

    public function all(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} WHERE Activo = 1");
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => $this->mapToEntity($row), $rows);
    }

    //Obtiene los préstamos activos (no devueltos) de un lector.
     
    public function findPrestamosActivosByLector(int $idLector): array
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE ID_Lector = :idLector 
                AND Estado_Entrega = 'Pendiente' 
                AND Activo = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idLector' => $idLector]);
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => $this->mapToEntity($row), $rows);
    }

    /*Obtiene el préstamo activo asociado a un ejemplar (si existe)*/

    public function findPrestamosActivosByEjemplar(int $idEjemplar): ?Prestamo
    {
        $sql = "SELECT p.* 
                FROM {$this->table} p
                JOIN ejemplar_prestamo ep ON p.ID_Prestamo = ep.ID_Prestamo
                WHERE ep.ID_Ejemplar = :idEjemplar 
                AND p.Estado_Entrega = 'Pendiente'
                AND p.Activo = 1
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idEjemplar' => $idEjemplar]);
        $row = $stmt->fetch();
        return $row ? $this->mapToEntity($row) : null;
    }
    
 
     //Registra la devolución de un préstamo (fecha real y nuevo estado).

    public function registrarDevolucion(int $idPrestamo, string $fechaReal, string $estado): bool
    {
        $sql = "UPDATE {$this->table} 
                SET Fecha_Recepcion_Real = :fechaReal, Estado_Entrega = :estado
                WHERE {$this->primaryKey} = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':fechaReal' => $fechaReal,
            ':estado'    => $estado,
            ':id'        => $idPrestamo
        ]);
    }

    //Mapea una fila de la BD a una entidad Prestamo.
    protected function mapToEntity(array $row): object
    {
        return Prestamo::fromArray($row);
    }
}