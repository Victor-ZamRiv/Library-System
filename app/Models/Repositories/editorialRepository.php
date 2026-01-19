<?php
namespace App\Models\Repositories;

use App\Contracts\IEditorialRepository;
use App\Core\baseRepository;
use App\Models\Entities\Editorial;
use PDO;

class EditorialRepository extends baseRepository implements IEditorialRepository{
    public function __construct(PDO $pdo){
        parent::__construct($pdo, 'editoriales', 'ID_Editorial');
    }

    public function insert(Editorial $editorial): int {
        if ($editorial->getId() !== null) {
            throw new \InvalidArgumentException("La editorial ya tiene ID, no puede insertarse");
        }

        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (Nombre) VALUES (?)");
        $stmt->execute([$editorial->getNombre()]);
        return (int)$this->pdo->lastInsertId();
    }

    public function find(int $id): ?Editorial {
        $row = $this->fetchById($id);
        return $row ? $this->mapToEntity($row) : null;
    }

    public function findByName(string $nombre): ?Editorial {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE Nombre = ?");
        $stmt->execute([$nombre]);
        $row = $stmt->fetch();

        return $row ? $this->mapToEntity($row) : null;
    }

    protected function mapToEntity(array $row): object {
        return Editorial::fromArray($row);
    }
}
?>