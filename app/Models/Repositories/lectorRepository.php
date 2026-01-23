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

    /**
     * Buscar lector por ID
     */
    public function find(int $id): ?Lector {
        $row = $this->fetchById($id);
        return $row ? Lector::fromArray($row) : null;
    }

    //Buscar lector por carnet
    public function findByCarnet(string $carnet): ?Lector {
        $stmt = $this->pdo->prepare("SELECT * FROM lectores WHERE Carnet = :carnet AND Activo = 1");
        $stmt->execute([':carnet' => $carnet]);
        $row = $stmt->fetch();
        return $row ? Lector::fromArray($row) : null;
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

    // Insertar lector (requiere ID_Persona ya existente)
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
            ':vencimientoCarnet' => $lector->getVencimientoCarnet(),
            ':activo' => $lector->getEstado() === 'Activo' ? 1 : 0,
            ':id' => $lector->getIdLector()
        ]);
    }

    public function deactivate(int $idLector): void {
        $sql = "UPDATE lectores SET Activo = 0 WHERE ID_Lector = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $idLector]);
    }

    protected function mapToEntity(array $row): object {
        return Lector::fromArray($row);
    }
}