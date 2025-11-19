<?php
namespace App\Models\Repositories;
use App\Core\baseRepository;
use App\Models\Entities\Editorial;
use PDO;

class EditorialRepository extends baseRepository{
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

    protected function mapToEntity(array $row): object {
        return new Editorial(
            $row['ID_Editorial'] ?? null,
            $row['Nombre'] ?? ''
        );
    }
}
?>