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

    // Insertar lector (requiere ID_Persona ya existente)
    public function insert(Lector $lector): int {
        if ($lector->getIdLector() !== null) {
            throw new \InvalidArgumentException("El lector ya tiene ID, no puede insertarse");
        }

        $sql = "INSERT INTO lectores (
                    ID_Persona, Carnet, Sexo, Direccion, Ocupacion, 
                    Telefono_Ocupacion, Direccion_Ocupacion, Ref_Personal, Ref_Personal_Tel, 
                    Ref_Laboral, Ref_Laboral_Tel, Estado, Vencimiento_Carnet, Activo
                ) VALUES (
                    :idPersona, :carnet, :sexo, :direccion, :ocupacion,
                    :telefonoOcupacion, :direccionOcupacion, :refPersonal, :refPersonalTel,
                    :refLaboral, :refLaboralTel, :estado, :vencimientoCarnet, :activo
                )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':idPersona' => $lector->getIdPersona(),
            ':carnet' => $lector->getCarnet(),
            ':sexo' => $lector->getSexo(),
            ':direccion' => $lector->getDireccion(),
            ':ocupacion' => $lector->getOcupacion(),
            ':telefonoOcupacion' => $lector->getTelefonoOcupacion(),
            ':direccionOcupacion' => $lector->getDireccionOcupacion(),
            ':refPersonal' => $lector->getRefPersonal(),
            ':refPersonalTel' => $lector->getRefPersonalTel(),
            ':refLaboral' => $lector->getRefLaboral(),
            ':refLaboralTel' => $lector->getRefLaboralTel(),
            ':estado' => $lector->getEstado(),
            ':vencimientoCarnet' => $lector->getVencimientoCarnet(),
            ':activo' => 1
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(Lector $lector): bool {
        $sql = "UPDATE lectores SET 
                    Carnet = :carnet, Sexo = :sexo, Direccion = :direccion, Ocupacion = :ocupacion,
                    Telefono_Ocupacion = :telefonoOcupacion, Direccion_Ocupacion = :direccionOcupacion,
                    Ref_Personal = :refPersonal, Ref_Personal_Tel = :refPersonalTel,
                    Ref_Laboral = :refLaboral, Ref_Laboral_Tel = :refLaboralTel,
                    Estado = :estado, Vencimiento_Carnet = :vencimientoCarnet, Activo = :activo
                WHERE ID_Lector = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':carnet' => $lector->getCarnet(),
            ':sexo' => $lector->getSexo(),
            ':direccion' => $lector->getDireccion(),
            ':ocupacion' => $lector->getOcupacion(),
            ':telefonoOcupacion' => $lector->getTelefonoOcupacion(),
            ':direccionOcupacion' => $lector->getDireccionOcupacion(),
            ':refPersonal' => $lector->getRefPersonal(),
            ':refPersonalTel' => $lector->getRefPersonalTel(),
            ':refLaboral' => $lector->getRefLaboral(),
            ':refLaboralTel' => $lector->getRefLaboralTel(),
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