<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Services\AdministradorRegistrationService;
use App\Contracts\IAdministradorRepository;
use App\Models\Entities\Persona;
use App\Models\Entities\Administrador;
use RuntimeException;

class AdministradorController extends BaseController {

    private AdministradorRegistrationService $registrationService;
    private IAdministradorRepository $adminRepo;

    public function __construct(AdministradorRegistrationService $registrationService, IAdministradorRepository $adminRepo) {
        $this->registrationService = $registrationService;
        $this->adminRepo = $adminRepo;
    }

    public function list(): string {
        $administradores = $this->adminRepo->all();
        return $this->render('user/user-list', ['administradores' => $administradores]);
    }

    public function create(): string {
        return $this->render('user/user');
    }
    
    public function store() {
        try {
            // 1. Construir entidad Persona desde los inputs
            $persona = new Persona(
                null,
                $this->input('cedula'),
                $this->input('nombre-reg'),
                $this->input('apellido-reg'),
                $this->input('email'),
                $this->input('telf-reg')
            );

            // 2. Construir entidad Administrador desde los inputs
            $admin = new Administrador(
                null,
                0, // ID_Persona se asignará en el service
                $this->input('usuario-reg'),
                password_hash($this->input('password1-reg'), PASSWORD_DEFAULT),
                $this->input('rol'), // Ej: Director, Jefe de sala, Bibliotecario
                true
            );

            // 3. Delegar al service
            $idAdmin = $this->registrationService->registrar($persona, $admin);

            $_SESSION['success'] = "Administrador registrado con éxito (ID: $idAdmin).";
            $this->redirect("/administradores/list");

        } catch (\RuntimeException $e) {
            http_response_code(500);
            return $this->render('errors/error', [
                'mensaje' => "Ocurrió un error inesperado al registrar el libro.",
                'detalle' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al registrar administrador: " . $e->getMessage();
            $_SESSION['old_data'] = $_POST;
            $this->redirect("/administradores/register");
        }
    }
}