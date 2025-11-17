<?php 
    namespace App\Models\Repositories;

    use PDO;
    use App\Core\baseRepository;
    use App\Entities\Libro;

    class LibroRepository extends baseRepository{
        public function __construct(PDO $pdo)
        {
            parent::__construct($pdo, 'libros');
        }

        public function all(): array{
            $stmt = $this->pdo->query("SELECT * fROM {$this->table} WHERE activo = 1");
            $rows = $stmt->fetchAll();
            return array_map(fn($r) => Libro::fromArray($r), $rows);
        }
        public function find(int $id): ?object {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE ID_Libro = ? LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? Libro::fromArray($row) : null;
    }

    public function save(object $entity): int {
        if (!($entity instanceof Libro)) throw new \InvalidArgumentException("Entidad inválida");

        $data = $entity->toArray();

        if ($entity->getId() === null) {
            $sql = "INSERT INTO {$this->table} (Titulo, Activo) VALUES (?, ?)";
            $this->pdo->prepare($sql)->execute([$data['Titulo'], $data['Activo']]);
            return (int)$this->pdo->lastInsertId();
        } else {
            $sql = "UPDATE {$this->table} SET Titulo = ?, Activo = ? WHERE ID_Libro = ?";
            $this->pdo->prepare($sql)->execute([$data['Titulo'], $data['Activo'], $data['ID_Libro']]);
            return $data['ID_Libro'];
        }
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE ID_Libro = ?");
        return $stmt->execute([$id]);
    }


    }
?>