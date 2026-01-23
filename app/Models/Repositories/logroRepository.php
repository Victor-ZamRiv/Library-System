<?php

namespace App\Models\Repositories;

use App\Core\BaseRepository;
use App\Contracts\ILogroRepository;
use App\Models\Entities\Logro;
use PDO;

class LogroRepository extends BaseRepository implements ILogroRepository {

    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'logros', 'ID_Logro');
    }

    public function find(int $id): ?Logro {
        $row = $this->fetchById($id);
        return $row ? $this->mapToEntity($row) : null;
    }

    public function insert(Logro $logro): int {
        if ($logro->getIdLogro() !== null) {
            throw new \InvalidArgumentException("El logro ya tiene ID, no puede insertarse");
        }

        $sql = "INSERT INTO logros (ID_Admin, Descripcion, Involucrados, Fecha, Activo)
                VALUES (:idAdmin, :descripcion, :involucrados, :fecha, 1)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':idAdmin' => $logro->getIdAdmin(),
            ':descripcion' => $logro->getDescripcion(),
            ':involucrados' => $logro->getInvolucrados(),
            ':fecha' => $logro->getFecha()
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(Logro $logro): bool {
        if ($logro->getIdLogro() === null) {
            throw new \InvalidArgumentException("El logro no tiene ID, no puede actualizarse");
        }

        $sql = "UPDATE logros SET 
                    Descripcion = :descripcion,
                    Involucrados = :involucrados,
                    Fecha = :fecha
                WHERE ID_Logro = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':descripcion' => $logro->getDescripcion(),
            ':involucrados' => $logro->getInvolucrados(),
            ':fecha' => $logro->getFecha(),
            ':id' => $logro->getIdLogro()
        ]);
    }

    protected function mapToEntity(array $row): object {
        return Logro::fromArray($row);
    }
}
