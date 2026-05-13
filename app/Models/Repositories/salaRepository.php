<?php
namespace App\Models\Repositories;
use App\Core\BaseRepository;
use App\Contracts\ISalaRepository;
use App\Models\Entities\Sala;
use PDO;

class SalaRepository extends BaseRepository implements ISalaRepository {
    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'salas', 'ID_Sala');
    }

    public function find(string $idSala): ?Sala
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE ID_Sala = :id");
        $stmt->execute([':id' => $idSala]);
        $row = $stmt->fetch();
        return $row ? $this->mapToEntity($row) : null;
    }

    public function listDisponibles(): array {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} WHERE Disponible = 1");
        $salas = [];
        while ($row = $stmt->fetch()) {
            $salas[] = $this->mapToEntity($row);
        }
        return $salas;
    }

    public function updateCapacidad(string $idSala, int $capacidad): bool
    {
        $sql = "UPDATE {$this->table} SET Capacidad = :capacidad WHERE ID_Sala = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':capacidad' => $capacidad, ':id' => $idSala]);
    }

    public function updateDisponible(string $idSala, int $disponible): bool
    {
        $sql = "UPDATE {$this->table} SET Disponible = :disponible WHERE ID_Sala = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':disponible' => $disponible, ':id' => $idSala]);
    }

    protected function mapToEntity(array $row): Sala {
        return Sala::fromArray($row);
    }
}