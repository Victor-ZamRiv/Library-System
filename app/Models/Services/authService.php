<?php
namespace App\Models\Services;

use App\Contracts\IAdministradorRepository;
use App\Models\Entities\Administrador;

class AuthService {

    private IAdministradorRepository $AdministradorRepo;

    public function __construct(IAdministradorRepository $AdministradorRepo) {
        $this->AdministradorRepo = $AdministradorRepo;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    
    public function login(string $email, string $password): bool {
        $Administrador = $this->AdministradorRepo->findByEmail($email);

        if (!$Administrador) {
            return false; // Administrador no encontrado
        }

        if (!password_verify($password, $Administrador->getContrasenaHash())) {
            return false; // Contraseña incorrecta
        }

        // Guardar datos mínimos en sesión
        $_SESSION['administrador'] = [
            'id' => $Administrador->getIdAdministrador(),
            'nombre' => $Administrador->getNombre(),
            'email' => $Administrador->getEmail(),
            'rol' => $Administrador->getRol()
        ];

        return true;
    }


    public function logout(): void {
        unset($_SESSION['administrador']);
        session_destroy();
    }

    //Verifica si hay un Administrador autenticado
    public function isAuthenticated(): bool {
        return isset($_SESSION['administrador']);
    }


    public function getCurrentUser(): ?array {
        return $_SESSION['administrador'] ?? null;
    }


    public function hasRole(string $rol): bool {
        return $this->isAuthenticated() && $_SESSION['administrador']['rol'] === $rol;
    }
}