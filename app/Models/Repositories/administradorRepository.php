<?php

namespace App\Models\Repositories;

use App\Core\BaseRepository;
use App\Contracts\IAdministradorRepository;
use App\Models\Entities\Administrador;
use PDO;

class AdministradorRepository extends BaseRepository implements IAdministradorRepository {

    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'administradores', 'ID_Admin');
    }

    public function find(int $id): ?Administrador {
        $row = $this->fetchById($id);
        return $row ? $this->mapToEntity($row) : null;
    }

    public function findByEmail(string $email): ?Administrador {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE Email = :email AND Activo = 1");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();
        return $row ? $this->mapToEntity($row) : null;
    }

    public function findByUsername(string $username): ?Administrador
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} Where NombreAdministrador = :nombre AND Activo = 1");
        $stmt->execute([':nombre' => $username]);
        $row = $stmt->fetch();
        return $row ? $this->mapToEntity($row) : null;
    }

    public function insert(Administrador $Administrador): int {
        if ($Administrador->getIdAdministrador() !== null) {
            throw new \InvalidArgumentException("El Administrador ya tiene ID, no puede insertarse");
        }

        $sql = "INSERT INTO administradores (ID_Persona, Nombre_Usuario, Contrasena, Rol, Activo)
                VALUES (:idPersona, :nombreUsuario, :contrasena, :rol, :activo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':idPersona' => $Administrador->getIdPersona(),
            ':nombreUsuario' => $Administrador->getNombreUsuario(),
            ':contrasena' => $Administrador->getContrasena(),
            ':rol' => $Administrador->getRol(),
            ':activo' => $Administrador->isActivo() ? 1 : 0
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(Administrador $Administrador): bool {
        $sql = "UPDATE administradores 
                SET ID_Persona = :idPersona, Nombre_Usuario = :nombreUsuario, Contrasena = :contrasena, Rol = :rol, Activo = :activo
                WHERE ID_Administrador = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idPersona' => $Administrador->getIdPersona(),
            ':nombreUsuario' => $Administrador->getNombreUsuario(),
            ':contrasena' => $Administrador->getContrasena(),
            ':rol' => $Administrador->getRol(),
            ':activo' => $Administrador->isActivo() ? 1 : 0,
            ':id' => $Administrador->getIdAdministrador()
        ]);
    }

    public function deactivate(int $idAdministrador): void {
        $sql = "UPDATE administradors SET Activo = 0 WHERE ID_Administrador = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $idAdministrador]);
    }

    protected function mapToEntity(array $row): object {
        return Administrador::fromArray($row);
    }
}