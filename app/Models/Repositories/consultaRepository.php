<?php

namespace App\Models\Repositories;

use App\Contracts\IConsultaRepository;
use App\Core\BaseRepository;
use App\Models\Entities\ConsultaRegistro;
use PDO;

class ConsultaRepository extends BaseRepository implements IConsultaRepository{

    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'consultas_area_diarias', 'ID_Consulta_Area');
    }

    public function find(int $id): ?ConsultaRegistro {
        $row = $this->fetchById($id);
        return $row ? $this->mapToEntity($row) : null;
    }

    public function insert(ConsultaRegistro $consulta): int {
        if ($consulta->getIdConsultaArea() !== null) {
            throw new \InvalidArgumentException("La consulta ya tiene ID, no puede insertarse");
        }

        $sql = "INSERT INTO consultas_area_diarias 
                (ID_Sala, ID_Area, Fecha, Cantidad_Consultada, ID_Admin)
                VALUES (:idSala, :idArea, :fecha, :cantidad, :idAdmin)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':idSala' => $consulta->getIdSala(),
            ':idArea' => $consulta->getIdArea(),
            ':fecha' => $consulta->getFecha(),
            ':cantidad' => $consulta->getCantidadConsultada(),
            ':idAdmin' => $consulta->getIdAdmin()
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(ConsultaRegistro $consulta): bool {
        if ($consulta->getIdConsultaArea() === null) {
            throw new \InvalidArgumentException("La consulta no tiene ID, no puede actualizarse");
        }

        $sql = "UPDATE consultas_area_diarias SET
                    ID_Sala = :idSala,
                    ID_Area = :idArea,
                    Fecha = :fecha,
                    Cantidad_Consultada = :cantidad,
                    ID_Admin = :idAdmin
                WHERE ID_Consulta_Area = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idSala' => $consulta->getIdSala(),
            ':idArea' => $consulta->getIdArea(),
            ':fecha' => $consulta->getFecha(),
            ':cantidad' => $consulta->getCantidadConsultada(),
            ':idAdmin' => $consulta->getIdAdmin(),
            ':id' => $consulta->getIdConsultaArea()
        ]);
    }

    public function findBySalaAndFecha(string $idSala, string $fecha): array {
        $sql = "SELECT * FROM consultas_area_diarias WHERE ID_Sala = :idSala AND Fecha = :fecha";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idSala' => $idSala, ':fecha' => $fecha]);
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => $this->mapToEntity($row), $rows);
    }

    public function existsBySalaFechaTurnoArea(string $idSala, string $fecha, string $turno, string $idArea): bool {
        $sql = "SELECT COUNT(*) FROM consultas_area_diarias 
                WHERE ID_Sala = :idSala AND Fecha = :fecha AND Turno = :turno AND ID_Area = :idArea";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':idSala' => $idSala,
            ':fecha' => $fecha,
            ':turno' => $turno,
            ':idArea' => $idArea
        ]);
        return $stmt->fetchColumn() > 0;
    }


    protected function mapToEntity(array $row): ConsultaRegistro {
        return ConsultaRegistro::fromArray($row);
    }
}
