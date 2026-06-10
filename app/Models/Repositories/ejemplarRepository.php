<?php
namespace App\Models\Repositories;

use PDO;
use App\Models\Entities\Ejemplar;
use App\Core\BaseRepository;
use App\Contracts\IEjemplarRepository;

class EjemplarRepository extends BaseRepository implements IEjemplarRepository {
    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'ejemplares', 'ID_Ejemplar');
    }

    // Inserta un nuevo ejemplar

    public function insert(array $data): int {
        $sql = "INSERT INTO ejemplares (ID_Libro, Numero_Ejemplar, Estado, Activo)
                VALUES (:libroId, :numeroEjemplar, :estado, :activo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':libroId' => $data['ID_Libro'],
            ':numeroEjemplar' => $data['Numero_Ejemplar'],
            ':estado' => $data['Estado'],
            ':activo' => $data['Activo']
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    // Metodos de lectura

    public function find(int $id): ?Ejemplar {
        $row = $this->fetchById($id);
        return $row ? $this->mapToEntity($row) : null;
    }
    
    public function findByLibro(int $libroId): array {
        $sql = "SELECT * FROM ejemplares WHERE ID_Libro = :libroId AND Activo = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':libroId' => $libroId]);

        $rows = $stmt->fetchAll();
        $ejemplares = [];
        foreach ($rows as $row) {
            $ejemplares[] = new Ejemplar(
                (int)$row['ID_Ejemplar'],
                (int)$row['Numero_Ejemplar'],
                $row['Estado'],
                (bool)$row['Activo'],
                (int)$row['ID_Libro']
            );
        }
        return $ejemplares;
    }

    public function getMaxNumeroEjemplar(int $idLibro): int {
        $sql = "SELECT MAX(Numero_Ejemplar) as max_numero 
                FROM ejemplares 
                WHERE ID_Libro = :idLibro";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idLibro' => $idLibro]);
        $max = $stmt->fetchColumn();
        return $max ? (int)$max : 0;
    }


    // Actualiza el estado de un ejemplar

    public function updateEstado(Ejemplar $ejemplar): bool {
        $sql = "UPDATE ejemplares SET Estado = :estado WHERE ID_Ejemplar = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':estado' => $ejemplar->getEstado(),
            ':id' => $ejemplar->getIdEjemplar()
        ]);
    }

    /**
     * Obtiene los ejemplares descatalogados (Activo = 0) de un libro específico.
     * @param int $idLibro
     * @return Ejemplar[]
     */
    public function findDescatalogadosPorLibro(int $idLibro): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE ID_Libro = :idLibro AND Activo = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idLibro' => $idLibro]);
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => $this->mapToEntity($row), $rows);
    }

    /**
     * Reactiva un ejemplar (cambia Activo a 1 y Estado a 'Disponible').
     * @param int $idEjemplar
     * @return bool
     */
    public function reactivar(int $idEjemplar): bool
    {
        $sql = "UPDATE {$this->table} SET Activo = 1, Estado = 'Disponible' WHERE ID_Ejemplar = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $idEjemplar]);
    }
    
    public function deactivate(int $ejemplarId): void {
        $sql = "UPDATE ejemplares SET Activo = 0 WHERE ID_Ejemplar = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $ejemplarId]);
    }

    protected function mapToEntity(array $row): object {
        return Ejemplar::fromArray($row);
    }
}