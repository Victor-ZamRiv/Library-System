<?php
namespace App\Models\Repositories;

use App\Core\BaseRepository;
use App\Models\Entities\Libro;
use PDO;

class LibroRepository extends BaseRepository {
    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'libros', 'ID_Libro');
    }
    
    public function search(array $filtros): array {
        $sql = "
            SELECT DISTINCT l.*
            FROM libros l
            LEFT JOIN libros_autores la ON l.ID_Libro = la.ID_Libro
            LEFT JOIN autores a ON la.ID_Autor = a.ID_Autor
            WHERE l.Activo = 1
        ";
        $params = [];

        // Búsqueda principal
        if (!empty($filtros['campo']) && !empty($filtros['valor'])) {
            switch ($filtros['campo']) {
                case 'autor':
                    $sql .= " AND a.Nombre LIKE ?";
                    $params[] = '%' . $filtros['valor'] . '%';
                    break;
                case 'titulo':
                    $sql .= " AND l.Titulo LIKE ?";
                    $params[] = '%' . $filtros['valor'] . '%';
                    break;
                case 'cota':
                    $sql .= " AND l.Cota LIKE ?";
                    $params[] = '%' . $filtros['valor'] . '%';
                    break;
            }
        }

        // Filtro por sala
        if (!empty($filtros['sala'])) {
            $sql .= " AND l.Sala = ?";
            $params[] = $filtros['sala'];
        }

        // Filtro por área de conocimiento
        if (!empty($filtros['area'])) {
            $sql .= " AND l.Area_Conocimiento = ?";
            $params[] = $filtros['area'];
        }

        return $this->runFilteredQuery($sql, $params);
    }

    public function insert(Libro $libro): int {
        if ($libro->getId() !== null) {
            throw new \InvalidArgumentException("El libro ya tiene ID, no puede insertarse");
        }

        try{
            $data = $libro->toArray();
            var_dump($data);
            $sql = "INSERT INTO {$this->table} (
                                Titulo,
                                ID_Editorial,
                                ID_Area,
                                ID_Sala,
                                Cota,
                                ISBN,
                                Paginas,
                                Volumen,
                                Observaciones,
                                Anio_Publicacion,
                                Activo
                            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                        $data['titulo'] ?? '',
                        $data['idEditorial'] ?? null,
                        $data['idArea'] ?? null,
                        $data['idSala'] ?? 'G',
                        $data['cota'] ?? '',
                        $data['isbn'] ?? null,
                        $data['paginas'] ?? null,
                        $data['volumen'] ?? null,
                        $data['observaciones'] ?? null,
                        $data['anioPublicacion'] ?? null,
                        isset($data['activo']) ? (int)$data['activo'] : 1
                ]);
            return (int)$this->pdo->lastInsertId();

        } catch (\PDOException $e) {
        throw new \RuntimeException("Error al insertar libro: " . $e->getMessage(), 0, $e);
    }


        

    }

    public function associateAutor(int $idLibro, int $idAutor): bool {
        $sql = "INSERT INTO libros_autores (ID_Libro, ID_Autor) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$idLibro, $idAutor]);
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