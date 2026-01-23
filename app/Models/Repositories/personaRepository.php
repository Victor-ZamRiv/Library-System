<?php
namespace App\Models\Repositories;

use App\Core\BaseRepository;
use App\Contracts\IPersonaRepository;
use App\Models\Entities\Persona;
use PDO;

class PersonaRepository extends BaseRepository Implements IPersonaRepository {

    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'persona', 'ID_Persona');
    }

    public function find(int $id): ?Persona {
        $row = $this->fetchById($id);
        return $row ? Persona::fromArray($row) : null;
    }

    public function findByEmail(?string $email): ?Persona {
        if (!$email) {
            return null;
        }
        $stmt = $this->pdo->prepare("SELECT * FROM persona WHERE Email = :email");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();
        return $row ? Persona::fromArray($row) : null;
    }

    public function findByCedula(string $cedula): ?Persona {
        $stmt = $this->pdo->prepare("SELECT * FROM persona WHERE Cedula = :cedula AND Activo = 1");
        $stmt->execute([':cedula' => $cedula]);
        $row = $stmt->fetch();
        return $row ? Persona::fromArray($row) : null;
    }

    public function findByNombreApellido(string $nombre, string $apellido): ?Persona {
        $stmt = $this->pdo->prepare("SELECT * FROM persona WHERE Nombre LIKE %:nombre% OR Apellido LIKE %:apellido% AND Activo = 1");
        $stmt->execute([
            ':nombre' => $nombre,
            ':apellido' => $apellido
        ]);
        $row = $stmt->fetch();
        return $row ? Persona::fromArray($row) : null;
    }

    public function insert(Persona $persona): int {
        if ($persona->getIdPersona() !== null) {
            throw new \InvalidArgumentException("La persona ya tiene ID, no puede insertarse");
        }

        $sql = "INSERT INTO persona (Cedula, Nombre, Apellido, Telefono)
                VALUES (:cedula, :nombre, :apellido, :telefono)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':cedula' => $persona->getCedula(),
            ':nombre' => $persona->getNombre(),
            ':apellido' => $persona->getApellido(),
            //':email' => $persona->getEmail(),
            ':telefono' => $persona->getTelefono()
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    
    public function update(Persona $persona): bool {
        if ($persona->getIdPersona() === null) {
            throw new \InvalidArgumentException("La persona no tiene ID, no puede actualizarse");
        }

        $sql = "UPDATE persona 
                SET Nombre = :nombre, Apellido = :apellido, Email = :email, Telefono = :telefono
                WHERE ID_Persona = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $persona->getNombre(),
            ':apellido' => $persona->getApellido(),
            ':email' => $persona->getEmail(),
            ':telefono' => $persona->getTelefono(),
            ':id' => $persona->getIdPersona()
        ]);
    }

    protected function mapToEntity(array $row): object {
        return Persona::fromArray($row);
    }
}