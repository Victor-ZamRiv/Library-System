<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Services\AdministradorRegistrationService;
use App\Models\Services\ListAdministradorService;
use App\Contracts\IAdministradorRepository;
use App\Contracts\IPersonaRepository;
use App\Contracts\IPreguntaRepository;
use App\Models\Entities\Persona;
use App\Models\Entities\Administrador;
use RuntimeException;

class AdministradorController extends BaseController {

    private AdministradorRegistrationService $registrationService;
    private ListAdministradorService $listAdminService;
    private IAdministradorRepository $adminRepo;
    private IPersonaRepository $personaRepo;
    private IPreguntaRepository $preguntaRepo;

    public function __construct(AdministradorRegistrationService $registrationService, ListAdministradorService $listAdminService, 
                                IAdministradorRepository $adminRepo, IPersonaRepository $personaRepo, IPreguntaRepository $preguntaRepo) {
        $this->registrationService = $registrationService;
        $this->listAdminService = $listAdminService;
        $this->adminRepo = $adminRepo;
        $this->personaRepo = $personaRepo;
        $this->preguntaRepo = $preguntaRepo;
        $this->authenticate();
        //$this->middlewareRol(['Director','SUPER_ADMIN'], 'Administradores');
    }

    public function list(): string {
        $administradores = $this->listAdminService->listar();
        return $this->render('user/user-list', ['administradores' => $administradores]);
    }

    public function show(): string {
        $id = (int)$this->input('id', 0);
        $administrador = $this->adminRepo->find($id);

        if (!$administrador) {
            http_response_code(404);
            return "Administrador no encontrado";
        }
        $administrador->setPersona($this->personaRepo->find($administrador->getIdPersona()));
        //var_dump($administrador);
        return $this->render('data/my-data', ['administrador' => $administrador]);
    }

    public function search(): string {
        $input = $this->input('buscar', '');
        $administradores = $this->listAdminService->search($input);
        return $this->render('user/user-list', ['administradores' => $administradores]);
    }

    public function create(): string {
        $preguntas = $this->preguntaRepo->all();
        //var_dump($preguntas);
        return $this->render('user/user', ['preguntas' => $preguntas]);
    }

    public function passwordRecoveryForm(): string {
        return $this->render('login/password-recovery', );
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