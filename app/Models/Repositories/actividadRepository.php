<?php

namespace App\Models\Repositories;

use App\Core\BaseRepository;
use App\Contracts\IActividadRepository;
use App\Models\Entities\Actividad;
use PDO;

class ActividadRepository extends BaseRepository implements IActividadRepository {

    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'actividades', 'ID_Actividad');
    }

    public function find(int $id): ?Actividad {
        $row = $this->fetchById($id);
        return $row ? $this->mapToEntity($row) : null;
    }

    public function insert(Actividad $actividad): int {
        
        if ($actividad->getIdActividad() !== null) {
            throw new \InvalidArgumentException("La actividad ya tiene ID, no puede insertarse");
        }

        $sql = "INSERT INTO actividades 
                (ID_Admin, Organizador, Categoria, Estado, Asistentes, Descripcion, Fecha, Activo)
                VALUES (:idAdmin, :organizador, :categoria, :estado, :asistentes, :descripcion, :fecha, 1)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':idAdmin' => $actividad->getIdAdmin(),
            ':organizador' => $actividad->getOrganizador(),
            ':categoria' => $actividad->getCategoria(),
            ':estado' => $actividad->getEstado(),
            ':asistentes' => $actividad->getAsistentes(),
            ':descripcion' => $actividad->getDescripcion(),
            ':fecha' => $actividad->getFecha()
        ]);

        return (int)$this->pdo->lastInsertId();
        
    }

    public function update(Actividad $actividad): bool {
        if ($actividad->getIdActividad() === null) {
            throw new \InvalidArgumentException("La actividad no tiene ID, no puede actualizarse");
        }

        $sql = "UPDATE actividades SET 
                    Organizador = :organizador,
                    Categoria = :categoria,
                    Estado = :estado,
                    Asistentes = :asistentes,
                    Descripcion = :descripcion,
                    Fecha = :fecha
                WHERE ID_Actividad = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':organizador' => $actividad->getOrganizador(),
            ':categoria' => $actividad->getCategoria(),
            ':estado' => $actividad->getEstado(),
            ':asistentes' => $actividad->getAsistentes(),
            ':descripcion' => $actividad->getDescripcion(),
            ':fecha' => $actividad->getFecha(),
            ':id' => $actividad->getIdActividad()
        ]);
    }

    protected function mapToEntity(array $row): Actividad {
        return Actividad::fromArray($row);
    }
}