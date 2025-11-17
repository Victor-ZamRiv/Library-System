<?php
namespace App\Repositories;

use App\Core\BaseRepository;
use App\Entities\Libro;
use PDO;

class LibroRepository extends BaseRepository {
    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'libros', 'ID_Libro');
    }

    public function insert(Libro $libro): int {
        if ($libro->getId() !== null) {
            throw new \InvalidArgumentException("El libro ya tiene ID, no puede insertarse");
        }

        $data = $libro->toArray();
        $sql = "INSERT INTO {$this->table} (Titulo, Activo) VALUES (?, ?)";
        $this->pdo->prepare($sql)->execute([$data['Titulo'], $data['Activo']]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(Libro $libro): bool {
        if ($libro->getId() === null) {
            throw new \InvalidArgumentException("El libro no tiene ID, no puede actualizarse");
        }

        $data = $libro->toArray();
        $sql = "UPDATE {$this->table} SET Titulo = ?, Activo = ? WHERE {$this->primaryKey} = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$data['Titulo'], $data['Activo'], $data[$this->primaryKey]]);
    }


    protected function mapToEntity(array $row): object {
        return Libro::fromArray($row);
    }
}