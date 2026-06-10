<?php
namespace App\Models\Repositories;

use App\Core\BaseRepository;
use App\Contracts\ILibroRepository;
use App\Models\Entities\Libro;
use PDO;

class LibroRepository extends BaseRepository implements ILibroRepository {

    protected array $mapaColumnas = [
        'titulo'          => 'Titulo',
        'idEditorial'     => 'ID_Editorial',
        'idSala'          => 'ID_Sala',
        'idArea'          => 'ID_Area',
        'cota'            => 'Cota',
        'edicion'         => 'Edicion',
        'ciudad'          => 'Ciudad',
        'isbn'            => 'ISBN',
        'paginas'         => 'Paginas',
        'volumen'          => 'Volumen',
        'observaciones'   => 'Observaciones',
        'anioPublicacion' => 'Anio_Publicacion',
        'activo'          => 'Activo'
    ];


    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'libros', 'ID_Libro');
    }

    public function find(int $id): ?libro {
        $row = $this->fetchById($id);
        return $row ? $this->mapToEntity($row) : null;
    }

    public function findByCota(string $cota): ?Libro {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE Cota = :cota AND Activo = 1");
        $stmt->execute([':cota' => $cota]);
        $row = $stmt->fetch();
        return $row ? $this->mapToEntity($row) : null;
    }

    
    
    public function search(int $pagina = 1, int $porPagina = 12, array $filtros = []): array
    {
        $offset = ($pagina - 1) * $porPagina;
        
        // Base de la consulta (la misma que usas en search)
        $sql = "SELECT DISTINCT l.* 
                FROM libros l
                LEFT JOIN libros_autores la ON l.ID_Libro = la.ID_Libro
                LEFT JOIN autores a ON la.ID_Autor = a.ID_Autor
                WHERE l.Activo = 1";
        
        $params = [];
        
        // Aplicar filtros
        if (!empty($filtros['valor'])) {
            $busqueda = '%' . $filtros['valor'] . '%';
            switch ($filtros['campo']) {
                case 'autor':
                    $sql .= " AND a.Nombre LIKE ?";
                    $params[] = $busqueda;
                    break;
                case 'titulo':
                    $sql .= " AND l.Titulo LIKE ?";
                    $params[] = $busqueda;
                    break;
                case 'cota':
                    $sql .= " AND l.Cota LIKE ?";
                    $params[] = $busqueda;
                    break;
            }
        }
        
        if (!empty($filtros['sala']) && $filtros['sala'] !== 'todas') {
            $sql .= " AND l.ID_Sala = ?";
            $params[] = $filtros['sala'];
        }
        
        if (!empty($filtros['area']) && $filtros['area'] !== 'todas') {
            $sql .= " AND l.ID_Area = ?";
            $params[] = $filtros['area'];
        }
        
        // Consulta de conteo
        $countSql = "SELECT COUNT(*) FROM ($sql) AS total";
        $stmtCount = $this->pdo->prepare($countSql);
        $stmtCount->execute($params);
        $total = (int) $stmtCount->fetchColumn();
        
        // Consulta de datos con ORDER BY y LIMIT
        $dataSql = $sql . " ORDER BY l.ID_Libro DESC LIMIT ? OFFSET ?";
        $allParams = array_merge($params, [$porPagina, $offset]);
        $stmtData = $this->pdo->prepare($dataSql);
        $stmtData->execute($allParams);
        $rows = $stmtData->fetchAll();
        
        $libros = array_map(fn($row) => $this->mapToEntity($row), $rows);
        
        return [
            'datos' => $libros,
            'total' => $total,
            'pagina' => $pagina,
            'porPagina' => $porPagina,
            'ultimaPagina' => ceil($total / $porPagina)
        ];
    }

    public function existsCota(string $cota, ?int $excludeId = null): bool {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE Cota = :cota";
        if ($excludeId) {
            $sql .= " AND {$this->primaryKey} != :id";
        }
        
        $stmt = $this->pdo->prepare($sql);
        $params = ['cota' => $cota];
        if ($excludeId) $params['id'] = $excludeId;
        
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function existsISBN(string $isbn, ?int $excludeId = null): bool {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE ISBN = :isbn";
        if ($excludeId) {
            $sql .= " AND {$this->primaryKey} != :id";
        }
        
        $stmt = $this->pdo->prepare($sql);
        $params = ['isbn' => $isbn];
        if ($excludeId) $params['id'] = $excludeId;
        
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function insert(Libro $libro): int {
        if ($libro->getIdLibro() !== null) {
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
                                Edicion,
                                Ciudad,
                                ISBN,
                                Paginas,
                                Volumen,
                                Observaciones,
                                Anio_Publicacion,
                                Activo
                            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                        $data['titulo'] ?? '',
                        $data['idEditorial'] ?? null,
                        $data['idArea'] ?? null,
                        $data['idSala'] ?? 'G',
                        $data['cota'] ?? '',
                        $data['edicion'] ?? null,
                        $data['ciudad'] ?? null,
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
        $id = $libro->getIdLibro();
        if ($id === null) {
            throw new \InvalidArgumentException("No se puede actualizar un libro sin ID.");
        }

        $datosEntidad = $libro->toArray();
        $camposSQL = [];
        $valores = [];

        foreach ($this->mapaColumnas as $propiedad => $columna) {
            // 1. Saltamos la clave primaria porque no se debe actualizar en el SET
            if ($columna === $this->primaryKey) continue;

            // 2. Si la propiedad existe en el array de la entidad, la preparamos
            if (array_key_exists($propiedad, $datosEntidad)) {
                $camposSQL[] = "{$columna} = ?";
                $valores[] = $datosEntidad[$propiedad];
            }
        }

        // 3. Añadimos el ID al final para el WHERE
        $valores[] = $id;

        $sql = "UPDATE {$this->table} SET " . implode(', ', $camposSQL) . " WHERE {$this->primaryKey} = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($valores);
    }


    protected function mapToEntity(array $row): object {
        return Libro::fromArray($row);
    }
}
