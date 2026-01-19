<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Services\AdministradorRegistrationService;
use App\Models\Entities\Persona;
use App\Models\Entities\Administrador;

class AdministradorController extends BaseController {

    private AdministradorRegistrationService $registrationService;

    public function __construct(AdministradorRegistrationService $registrationService) {
        $this->registrationService = $registrationService;
    }

    
    public function registerForm(): string {
        return $this->render('administradores/register');
    }
    
    public function register(): void {
        try {
            // 1. Construir entidad Persona desde los inputs
            $persona = new Persona(
                null,
                $this->input('nombre'),
                $this->input('apellido'),
                $this->input('email'),
                $this->input('telefono')
            );

            // 2. Construir entidad Administrador desde los inputs
            $admin = new Administrador(
                null,
                0, // ID_Persona se asignará en el service
                $this->input('nombreUsuario'),
                password_hash($this->input('contrasena'), PASSWORD_DEFAULT),
                $this->input('rol', 'bibliotecario'),
                true
            );

            // 3. Delegar al service
            $idAdmin = $this->registrationService->registrar($persona, $admin);

            $_SESSION['success'] = "Administrador registrado con éxito (ID: $idAdmin).";
            $this->redirect("/administradores/list");

        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al registrar administrador: " . $e->getMessage();
            $_SESSION['old_data'] = $_POST;
            $this->redirect("/administradores/register");
        }
    }
}