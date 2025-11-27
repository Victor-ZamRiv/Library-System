<?php
namespace App\Models\Repositories;

use PDO;
use App\Models\Entities\Ejemplar;
use App\Core\BaseRepository;

class EjemplarRepository extends BaseRepository {
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

    // Obtiene todos los ejemplares de un libro
    
    public function findByLibro(int $libroId): array {
        $sql = "SELECT * FROM ejemplares WHERE ID_Libro = :libroId";
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

    // Actualiza el estado de un ejemplar

    public function updateEstado(int $ejemplarId, string $estado): void {
        $sql = "UPDATE ejemplares SET Estado = :estado WHERE ID_Ejemplar = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':estado' => $estado,
            ':id' => $ejemplarId
        ]);
    }

    // Marca un ejemplar como inactivo (eliminado lógico)

    public function deactivate(int $ejemplarId): void {
        $sql = "UPDATE ejemplares SET Activo = 0 WHERE ID_Ejemplar = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $ejemplarId]);
    }
    protected function mapToEntity(array $row): object {
        return Ejemplar::fromArray($row);
    }
}