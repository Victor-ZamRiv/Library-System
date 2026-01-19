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

    /**
     * Buscar persona por ID
     */
    public function find(int $id): ?Persona {
        $row = $this->fetchById($id);
        return $row ? Persona::fromArray($row) : null;
    }

    /**
     * Buscar persona por email
     */
    public function findByEmail(?string $email): ?Persona {
        if (!$email) {
            return null;
        }
        $stmt = $this->pdo->prepare("SELECT * FROM persona WHERE Email = :email");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();
        return $row ? Persona::fromArray($row) : null;
    }

    /**
     * Insertar nueva persona
     */
    public function insert(Persona $persona): int {
        if ($persona->getIdPersona() !== null) {
            throw new \InvalidArgumentException("La persona ya tiene ID, no puede insertarse");
        }

        $sql = "INSERT INTO persona (Nombre, Apellido, Email, Telefono)
                VALUES (:nombre, :apellido, :email, :telefono)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $persona->getNombre(),
            ':apellido' => $persona->getApellido(),
            ':email' => $persona->getEmail(),
            ':telefono' => $persona->getTelefono()
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Actualizar datos de persona
     */
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