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
use Exception;
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

    public function edit() {
        $id = (int)$this->input('id', 0);
        $administrador = $this->adminRepo->find($id);

        if (!$administrador) {
            http_response_code(404);
            $_SESSION['error'] = "Administrador no encontrado.";
            return $this->redirect('/administradores/show?id=' . $id);
        }
        $administrador->setPersona($this->personaRepo->find($administrador->getIdPersona()));
        $preguntas = $this->preguntaRepo->all();
        return $this->render('user/edit-user', ['administrador' => $administrador, 'preguntas' => $preguntas]);
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
                $this->input('pregunta-seguidad'),
                $this->input('respuesta-reg') ? password_hash($this->input('respuesta-reg'), PASSWORD_DEFAULT) : null,
                true
            );

            // 3. Delegar al service
            $idAdmin = $this->registrationService->registrar($persona, $admin);

            $_SESSION['success'] = "Administrador registrado con éxito (ID: $idAdmin).";
            $this->redirect("/administradores");

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

    public function update() {
        try {
            $idAdmin = (int)$this->input('idAdmin');
            $admin = $this->adminRepo->find($idAdmin);

            if (!$admin) {
                throw new Exception("Administrador no encontrado.");
            }
            $persona = $this->personaRepo->find($admin->getIdPersona());
            if (!$persona) {
                throw new Exception("Datos personales del administrador no encontrados.");
            }

            // Actualizar campos editables
            if ($this->input('username-up') !== $admin->getNombreUsuario() && $this->adminRepo->existsUsername($this->input('username-up'), $idAdmin)) {
                throw new Exception("El nombre de usuario ya está en uso por otro administrador.");
            }
            if ($admin->getNombreUsuario() !== $this->input('username-up')){
                $admin->setNombreUsuario($this->input('username-up'));
                $_SESSION['administrador']['nombre_usuario'] = $this->input('username-up');  
            }
            $persona->setTelefono($this->input('user-phone-up'));
            if ($this->input('password-up') && $this->input('password-up') !== '') {
                $admin->setContrasenaHash(password_hash($this->input('password-up'), PASSWORD_DEFAULT));
            }
            $admin->setRol($this->input('rol-up'));
            if ($this->input('pregunta-tipo-reg') && $admin->getIdPregunta() !== (int)$this->input('pregunta-tipo-reg')) {
                $admin->setIdPregunta($this->input('pregunta-tipo-reg'));
            }
            if ($this->input('pregunta-resp-reg') && $this->input('pregunta-resp-reg') !== '') {
                $admin->setRespuestaHash(password_hash($this->input('pregunta-resp-reg'), PASSWORD_DEFAULT));
            }

            // Delegar actualización al repositorio
            $this->personaRepo->update($persona);
            $this->adminRepo->update($admin);

            $_SESSION['success'] = "Administrador actualizado con éxito.";
            $this->redirect("/administradores/show?id=" . $idAdmin);

        } catch (\RuntimeException $e) {
            http_response_code(500);
            return $this->render('errors/error', [
                'mensaje' => "Ocurrió un error inesperado al actualizar el administrador.",
                'detalle' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al actualizar administrador: " . $e->getMessage();
            $_SESSION['old_data'] = $_POST;
            return $this->redirect("/administradores/edit?id=" . (int)$this->input('idAdmin', 0));
        }
    }

    public function delete() {
        $id = (int)$this->input('id', 0);
        $admin = $this->adminRepo->find($id);

        if (!$admin) {
            http_response_code(404);
            return "Administrador no encontrado";
        }

        try {
            $this->adminRepo->deactivate($id);
            $_SESSION['success'] = "Administrador desactivado con éxito.";
            $this->redirect("/administradores");
        } catch (\Exception $e) {
            http_response_code(500);
            return $this->render('errors/error', [
                'mensaje' => "Ocurrió un error inesperado al desactivar el administrador.",
                'detalle' => $e->getMessage()
            ]);
        }
    }
}