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
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} Where Nombre_Usuario = :nombre AND Activo = 1");
        $stmt->execute([':nombre' => $username]);
        $row = $stmt->fetch();
        return $row ? $this->mapToEntity($row) : null;
    }

    public function existsUsername(string $username, ?int $excludeId = null): bool {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE Nombre_Usuario = :username";
        $params = [':username' => $username];

        if ($excludeId !== null) {
            $sql .= " AND {$this->primaryKey} != :excludeId";
            $params[':excludeId'] = $excludeId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function duplicatePersona(int $idPersona): bool {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE ID_Persona = :idPersona";
        $params = [':idPersona' => $idPersona];

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function search(string $input): array {
        $sql = "SELECT * FROM {$this->table} WHERE Activo = 1";
        $params = [];

        if (!empty($input)) {
            $sql .= " AND Nombre_Usuario LIKE :nombreUsuario";
            $params[':nombreUsuario'] = '%' . $input . '%';
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => $this->mapToEntity($row), $rows);
    }

    public function insert(Administrador $Administrador): int {
        if ($Administrador->getIdAdministrador() !== null) {
            throw new \InvalidArgumentException("El Administrador ya tiene ID, no puede insertarse");
        }

        $sql = "INSERT INTO administradores (ID_Persona, Nombre_Usuario, ContrasenaHash, Rol, ID_Pregunta, RespuestaHash)
                VALUES (:idPersona, :nombreUsuario, :contrasena, :rol, :idPregunta, :respuestaHash)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':idPersona' => $Administrador->getIdPersona(),
            ':nombreUsuario' => $Administrador->getNombreUsuario(),
            ':contrasena' => $Administrador->getContrasenaHash(),
            ':rol' => $Administrador->getRol(),
            ':idPregunta' => $Administrador->getIdPregunta(),
            ':respuestaHash' => $Administrador->getRespuestaHash()
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(Administrador $Administrador): bool {
        $sql = "UPDATE administradores 
                SET ID_Persona = :idPersona, Nombre_Usuario = :nombreUsuario, ContrasenaHash = :contrasena, Rol = :rol, Activo = :activo
                WHERE ID_Administrador = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idPersona' => $Administrador->getIdPersona(),
            ':nombreUsuario' => $Administrador->getNombreUsuario(),
            ':contrasena' => $Administrador->getContrasenaHash(),
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