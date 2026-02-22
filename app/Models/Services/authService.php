<?php
namespace App\Models\Services;

use App\Contracts\IAdministradorRepository;
use App\Models\Entities\Administrador;

class AuthService {

    private IAdministradorRepository $AdministradorRepo;

    public function __construct(IAdministradorRepository $AdministradorRepo) {
        $this->AdministradorRepo = $AdministradorRepo;
        /*if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }*/
    }

    
    public function login(string $nombreUsuario, string $password): bool {
        try{

            if($nombreUsuario === SUPER_USER_NAME){
                if(password_verify($password, SUPER_USER_HASH)){
                    // Guardar datos mínimos en sesión
                    $_SESSION['administrador'] = [
                        'id' => 0,
                        'nombre_usuario' => SUPER_USER_NAME,
                        'rol' => 'SUPER_ADMIN'
                    ];
                    return true;
                } else {
                    return false; // Contraseña incorrecta
                }
            }

            $Administrador = $this->AdministradorRepo->findByUsername($nombreUsuario);

            if (!$Administrador) {
                return false; // Administrador no encontrado
            }

            if (!password_verify($password, $Administrador->getContrasenaHash())) {
                return false; // Contraseña incorrecta
            }

            // Guardar datos mínimos en sesión
            $_SESSION['administrador'] = [
                'id' => $Administrador->getIdAdministrador(),
                'nombre_usuario' => $Administrador->getNombreUsuario(),
                'rol' => $Administrador->getRol()
            ];

            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException("Error al intentar iniciar sesión: " . $e->getMessage());
        }
        
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