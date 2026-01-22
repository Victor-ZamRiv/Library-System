<?php
namespace App\Models\Repositories;

use App\Contracts\IAutorRepository;
use App\Core\baseRepository;
use App\Models\Entities\Autor;
use PDO;

class AutorRepository extends baseRepository implements IAutorRepository{
    public function __construct(PDO $pdo){
        parent::__construct($pdo, 'autores', 'ID_Autor');
    }

    public function find(int $id): ?Autor {
        $row = $this->fetchById($id);
        return $row ? $this->mapToEntity($row) : null;
    }

    public function insert(Autor $autor): int {
        if ($autor->getId() !== null) {
            throw new \InvalidArgumentException("El autor ya tiene ID, no puede insertarse");
        }

        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (Nombre) VALUES (?)");
        $stmt->execute([$autor->getNombre()]);
        return (int)$this->pdo->lastInsertId();
    }

    public function getAutoresLibro(int $idLibro): array {
        $sql = "
            SELECT a.*
            FROM autores a
            JOIN libros_autores la ON a.ID_Autor = la.ID_Autor
            WHERE la.ID_Libro = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idLibro]);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => Autor::fromArray($row), $rows);
    }

    public function deleteRelacionesPorLibro(int $idLibro): bool {
        $sql = "DELETE FROM libros_autores WHERE ID_Libro = ?";
        return $this->pdo->prepare($sql)->execute([$idLibro]);
    }

    public function vincularConLibro(int $idLibro, int $idAutor): bool {
        $sql = "INSERT INTO libros_autores (ID_Libro, ID_Autor) VALUES (?, ?)";
        return $this->pdo->prepare($sql)->execute([$idLibro, $idAutor]);
    }

    public function findByName(string $nombre): ?Autor {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE Nombre = ?");
        $stmt->execute([$nombre]);
        $row = $stmt->fetch();

        return $row ? $this->mapToEntity($row) : null;
    }

    protected function mapToEntity(array $row): object {
        return Autor::fromArray($row);
    }
}

?>