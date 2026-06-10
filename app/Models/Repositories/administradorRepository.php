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

    public function findByPersonaId(int $idPersona): ?Administrador {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE ID_Persona = :idPersona AND Activo = 1");
        $stmt->execute([':idPersona' => $idPersona]);
        $row = $stmt->fetch();
        return $row ? $this->mapToEntity($row) : null;
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

    /**
     * Obtiene administradores activos paginados (con búsqueda opcional)
     */
    // (Versión correcta que ya usaste para lectores)
public function listarActivosPaginados(int $pagina = 1, int $porPagina = 10, ?string $search = null): array
{
    $offset = ($pagina - 1) * $porPagina;
    $hasSearch = !empty($search);
    $where = "a.Activo = 1";
    $params = [];
    if ($hasSearch) {
        $where .= " AND (p.Nombre LIKE ? OR p.Apellido LIKE ? OR p.Cedula LIKE ? OR a.Nombre_Usuario LIKE ?)";
        $like = '%' . $search . '%';
        $params = [$like, $like, $like, $like];
    }
    $countSql = "SELECT COUNT(*) FROM administradores a
                 JOIN persona p ON a.ID_Persona = p.ID_Persona
                 WHERE $where";
    $stmtCount = $this->pdo->prepare($countSql);
    $stmtCount->execute($params);
    $total = (int) $stmtCount->fetchColumn();

    $sql = "SELECT a.* FROM administradores a
            JOIN persona p ON a.ID_Persona = p.ID_Persona
            WHERE $where
            ORDER BY a.ID_Admin DESC
            LIMIT ? OFFSET ?";
    $stmtData = $this->pdo->prepare($sql);
    $allParams = array_merge($params, [$porPagina, $offset]);
    $stmtData->execute($allParams);
    $rows = $stmtData->fetchAll();
    $admins = array_map(fn($row) => $this->mapToEntity($row), $rows);
    return [
        'datos' => $admins,
        'total' => $total,
        'pagina' => $pagina,
        'porPagina' => $porPagina,
        'ultimaPagina' => ceil($total / $porPagina)
    ];
}
    /**
     * Obtiene administradores inactivos (Activo = 0) con búsqueda opcional
     */
    public function findInactivos(?string $search = null): array
    {
        $hasSearch = !empty($search);
        $sql = "SELECT a.* FROM administradores a
                JOIN persona p ON a.ID_Persona = p.ID_Persona
                WHERE a.Activo = 0";
        $params = [];
        if ($hasSearch) {
            $sql .= " AND (p.Nombre LIKE ? OR p.Apellido LIKE ? OR p.Cedula LIKE ? OR a.Nombre_Usuario LIKE ?)";
            $like = '%' . $search . '%';
            $params = [$like, $like, $like, $like];
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => $this->mapToEntity($row), $rows);
    }

    /**
     * Cuenta administradores inactivos (para contador)
     */
    public function countInactivos(?string $search = null): int
    {
        $hasSearch = !empty($search);
        $sql = "SELECT COUNT(*) FROM administradores a
                JOIN persona p ON a.ID_Persona = p.ID_Persona
                WHERE a.Activo = 0";
        $params = [];
        if ($hasSearch) {
            $sql .= " AND (p.Nombre LIKE ? OR p.Apellido LIKE ? OR p.Cedula LIKE ? OR a.Nombre_Usuario LIKE ?)";
            $like = '%' . $search . '%';
            $params = [$like, $like, $like, $like];
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
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
                SET ID_Persona = :idPersona, Nombre_Usuario = :nombreUsuario, ContrasenaHash = :contrasena, 
                    Rol = :rol, RespuestaHash = :respuestaHash, Activo = :activo
                WHERE ID_Admin = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idPersona' => $Administrador->getIdPersona(),
            ':nombreUsuario' => $Administrador->getNombreUsuario(),
            ':contrasena' => $Administrador->getContrasenaHash(),
            ':rol' => $Administrador->getRol(),
            ':respuestaHash' => $Administrador->getRespuestaHash(),
            ':activo' => $Administrador->isActivo() ? 1 : 0,
            ':id' => $Administrador->getIdAdministrador()
        ]);
    }

    public function updatePassword(int $id, string $hash): bool
    {
        $stmt = $this->pdo->prepare("UPDATE administradores SET ContrasenaHash = :hash WHERE ID_Admin = :id");
        return $stmt->execute([':hash' => $hash, ':id' => $id]);
    }
    /**
     * Reactiva un administrador (Activo = 1)
     */
    public function reactivar(int $idAdmin): bool
    {
        $sql = "UPDATE {$this->table} SET Activo = 1 WHERE ID_Admin = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $idAdmin]);
    }

    protected function mapToEntity(array $row): object {
        return Administrador::fromArray($row);
    }
}