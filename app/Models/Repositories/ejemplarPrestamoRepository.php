<?php

namespace App\Models\Repositories;

use App\Core\BaseRepository;
use App\Contracts\IEjemplarPrestamoRepository;
use PDO;

class EjemplarPrestamoRepository extends BaseRepository implements IEjemplarPrestamoRepository
{
    public function __construct(PDO $pdo)
    {
        // No usamos el concepto de entidad, solo operaciones sobre la tabla intermedia
        parent::__construct($pdo, 'ejemplar_prestamo', 'ID_Prestamo_Ejemplar');
    }

    //Asocia un ejemplar a un préstamo.

    public function associate(int $idPrestamo, int $idEjemplar): bool
    {
        $sql = "INSERT INTO {$this->table} (ID_Prestamo, ID_Ejemplar) VALUES (:idPrestamo, :idEjemplar)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idPrestamo' => $idPrestamo,
            ':idEjemplar' => $idEjemplar
        ]);
    }

    //Obtiene los IDs de ejemplares asociados a un préstamo.
    
    public function findByPrestamo(int $idPrestamo): array
    {
        $sql = "SELECT ID_Ejemplar FROM {$this->table} WHERE ID_Prestamo = :idPrestamo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idPrestamo' => $idPrestamo]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /*Obtiene el ID del préstamo activo asociado a un ejemplar (si existe).
      Retorna null si no hay préstamo activo.*/
    public function findByEjemplar(int $idEjemplar): ?int
    {
        $sql = "SELECT ep.ID_Prestamo 
                FROM {$this->table} ep
                JOIN prestamos p ON ep.ID_Prestamo = p.ID_Prestamo
                WHERE ep.ID_Ejemplar = :idEjemplar 
                AND p.Estado_Entrega = 'Pendiente'
                AND p.Activo = 1
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idEjemplar' => $idEjemplar]);
        $id = $stmt->fetchColumn();
        return $id !== false ? (int) $id : null;
    }

    /*Método requerido por BaseRepository (aunque no se use directamente).
     *Como no tenemos entidad, retornamos un array vacío o lanzamos excepción. */
    protected function mapToEntity(array $row): object
    {
        throw new \LogicException("EjemplarPrestamoRepository no maneja entidades.");
    }
}