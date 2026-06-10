<?php
namespace App\Models\Repositories;

use App\Core\BaseRepository;
use App\Models\Entities\Lector;
use App\Contracts\ILectorRepository;
use PDO;

class LectorRepository extends BaseRepository implements ILectorRepository {

    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'lectores', 'ID_Lector');
    }

    //métodos de lectura

    public function find(int $id): ?Lector {
        $row = $this->fetchById($id);
        return $row ? Lector::fromArray($row) : null;
    }

    public function findByCarnet(string $carnet): ?Lector {
        $stmt = $this->pdo->prepare("SELECT * FROM lectores WHERE Carnet = :carnet AND Activo = 1");
        $stmt->execute([':carnet' => $carnet]);
        $row = $stmt->fetch();
        return $row ? Lector::fromArray($row) : null;
    }

    public function findByPersonaId(int $idPersona): ?Lector {
        $stmt = $this->pdo->prepare("SELECT * FROM lectores WHERE ID_Persona = :idPersona AND Activo = 1");
        $stmt->execute([':idPersona' => $idPersona]);
        $row = $stmt->fetch();
        return $row ? Lector::fromArray($row) : null;
    }

    public function findInactivos(): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE Activo = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => $this->mapToEntity($row), $rows);
    }

    public function search($input): array {
        $sql = "SELECT lectores.* FROM lectores
                JOIN persona ON lectores.ID_Persona = persona.ID_Persona
                WHERE (persona.Nombre LIKE :in1 
                OR persona.Apellido LIKE :in2 
                OR persona.Cedula LIKE :in3 
                OR lectores.Carnet LIKE :in4)
                AND lectores.Activo = 1";
        $stmt = $this->pdo->prepare($sql);

        $searchTerm = "%$input%";

        $stmt->execute([
            ':in1' => $searchTerm,
            ':in2' => $searchTerm,
            ':in3' => $searchTerm,
            ':in4' => $searchTerm
        ]);

        $rows = $stmt->fetchAll();
        return array_map(fn($row) => $this->mapToEntity($row), $rows);
    }

    /**
     * Obtiene lectores activos paginados (con búsqueda opcional)
     * @param int $pagina
     * @param int $porPagina
     * @param string|null $search
     * @return array ['datos' => Lector[], 'total' => int, 'pagina' => int, 'ultimaPagina' => int]
     */
    public function listarActivosPaginados(int $pagina = 1, int $porPagina = 10, ?string $search = null): array
{
    $offset = ($pagina - 1) * $porPagina;
    $hasSearch = !empty($search);

    // Construcción de WHERE y parámetros
    $where = "l.Activo = 1";
    $params = [];
    if ($hasSearch) {
        $where .= " AND (p.Nombre LIKE ? OR p.Apellido LIKE ? OR p.Cedula LIKE ? OR l.Carnet LIKE ?)";
        $like = '%' . $search . '%';
        $params = [$like, $like, $like, $like];
    }

    // Consulta de conteo (sin LIMIT)
    $countSql = "SELECT COUNT(*) FROM lectores l
                 JOIN persona p ON l.ID_Persona = p.ID_Persona
                 WHERE $where";
    $stmtCount = $this->pdo->prepare($countSql);
    $stmtCount->execute($params);
    $total = (int) $stmtCount->fetchColumn();

    // Consulta de datos con LIMIT y OFFSET
    $sql = "SELECT l.* FROM lectores l
            JOIN persona p ON l.ID_Persona = p.ID_Persona
            WHERE $where
            ORDER BY l.ID_Lector DESC
            LIMIT ? OFFSET ?";
    $stmtData = $this->pdo->prepare($sql);
    // Combinar parámetros de búsqueda con limit y offset
    $allParams = array_merge($params, [$porPagina, $offset]);
    $stmtData->execute($allParams);
    $rows = $stmtData->fetchAll();

    $lectores = array_map(fn($row) => $this->mapToEntity($row), $rows);

    return [
        'datos' => $lectores,
        'total' => $total,
        'pagina' => $pagina,
        'porPagina' => $porPagina,
        'ultimaPagina' => ceil($total / $porPagina)
    ];
}

    /**
     * Cuenta lectores inactivos (para mostrar el contador)
     */
    public function countInactivos(?string $search = null): int
    {
        $sql = "SELECT COUNT(*) FROM lectores l
                JOIN persona p ON l.ID_Persona = p.ID_Persona
                WHERE l.Activo = 0";
        $params = [];
        if (!empty($search)) {
            $sql .= " AND (p.Nombre LIKE :search OR p.Apellido LIKE :search OR p.Cedula LIKE :search OR l.Carnet LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    // Insertar lector (Persona ya existente)
    public function insert(Lector $lector): int {
        if ($lector->getIdLector() !== null) {
            throw new \InvalidArgumentException("El lector ya tiene ID, no puede insertarse");
        }

        if ($lector->getCarnet() && $this->findByCarnet($lector->getCarnet())) {
            throw new \RuntimeException("El carnet '{$lector->getCarnet()}' ya está registrado.");
        }


        $sql = "INSERT INTO lectores (
                    ID_Persona, Carnet, Sexo, Direccion, Profesion, 
                    Telefono_Profesion, Direccion_Profesion, Ref_Personal, Ref_Personal_Tel, 
                    Ref_Legal, Ref_Legal_Tel, Estado, Activo
                ) VALUES (
                    :idPersona, :carnet, :sexo, :direccion, :Profesion,
                    :telefonoProfesion, :direccionProfesion, :refPersonal, :refPersonalTel,
                    :refLegal, :refLegalTel, :estado, :activo
                )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':idPersona' => $lector->getIdPersona(),
            ':carnet' => $lector->getCarnet(),
            ':sexo' => $lector->getSexo(),
            ':direccion' => $lector->getDireccion(),
            ':Profesion' => $lector->getProfesion(),
            ':telefonoProfesion' => $lector->getTelefonoProfesion(),
            ':direccionProfesion' => $lector->getDireccionProfesion(),
            ':refPersonal' => $lector->getRefPersonal(),
            ':refPersonalTel' => $lector->getRefPersonalTel(),
            ':refLegal' => $lector->getRefLegal(),
            ':refLegalTel' => $lector->getRefLegalTel(),
            ':estado' => $lector->getEstado(),
            ':activo' => 1
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(Lector $lector): bool {
        $sql = "UPDATE lectores SET 
                    Carnet = :carnet, Sexo = :sexo, Direccion = :direccion, Profesion = :Profesion,
                    Telefono_Profesion = :telefonoProfesion, Direccion_Profesion = :direccionProfesion,
                    Ref_Personal = :refPersonal, Ref_Personal_Tel = :refPersonalTel,
                    Ref_Legal = :refLegal, Ref_Legal_Tel = :refLegalTel,
                    Estado = :estado, Activo = :activo
                WHERE ID_Lector = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':carnet' => $lector->getCarnet(),
            ':sexo' => $lector->getSexo(),
            ':direccion' => $lector->getDireccion(),
            ':Profesion' => $lector->getProfesion(),
            ':telefonoProfesion' => $lector->getTelefonoProfesion(),
            ':direccionProfesion' => $lector->getDireccionProfesion(),
            ':refPersonal' => $lector->getRefPersonal(),
            ':refPersonalTel' => $lector->getRefPersonalTel(),
            ':refLegal' => $lector->getRefLegal(),
            ':refLegalTel' => $lector->getRefLegalTel(),
            ':estado' => $lector->getEstado(),
            //':vencimientoCarnet' => $lector->getVencimientoCarnet(),
            ':activo' => $lector->getEstado() === 'Activo' ? 1 : 0,
            ':id' => $lector->getIdLector()
        ]);
    }

    //eliminación lógica

    public function deactivate(int $idLector): void {
        $sql = "UPDATE lectores SET Activo = 0 WHERE ID_Lector = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $idLector]);
    }

    /**
     * Reactiva un lector (Activo = 1, Estado = 'Activo')
     */
    public function reactivar(int $idLector): bool
    {
        $sql = "UPDATE {$this->table} SET Activo = 1, Estado = 'Activo' WHERE ID_Lector = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $idLector]);
    }

    protected function mapToEntity(array $row): object {
        return Lector::fromArray($row);
    }
}