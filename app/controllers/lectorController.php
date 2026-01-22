<?php
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\Services\LectorRegistrationService;
use App\Models\Services\ListLectorService;
use App\Contracts\ILectorRepository;
use App\Models\Entities\Persona;
use App\Models\Entities\Lector;

class LectorController extends BaseController {

    private LectorRegistrationService $registrationService;
    private ListLectorService $listLectorService;
    private ILectorRepository $lectorRepo;

    public function __construct(LectorRegistrationService $registrationService, ListLectorService $listLectorService, ILectorRepository $lectorRepo) {
        $this->registrationService = $registrationService;
        $this->listLectorService = $listLectorService;
        $this->lectorRepo = $lectorRepo;
    }

    public function list(): string {
        $lectores = $this->listLectorService->listar();
        return $this->render('reader/reader-list', ['lectores' => $lectores]);
    }

    public function create(): string {
        return $this->render('reader/reader');
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

            // 2. Construir entidad Lector desde los inputs
            $lector = new Lector(
                null,
                0, // ID_Persona se asignará en el service
                $this->input('usuario-reg'),
                password_hash($this->input('password1-reg'), PASSWORD_DEFAULT),
                true
            );

            // 3. Delegar al service
            $idLector = $this->registrationService->registrar($persona, $lector);

            $_SESSION['success'] = "Lector registrado con éxito (ID: $idLector).";
            $this->redirect("/lectores/list");
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al registrar lector: " . $e->getMessage();
            $this->redirect("/lectores/create");
        }
    }

    public function show(int $id): string {
        $lector = $this->lectorRepo->find($id);
        if (!$lector) {
            $_SESSION['error'] = "Lector no encontrado.";
            $this->redirect("/lectores/list");
        }
        return $this->render('lector/lector-detail', ['lector' => $lector]);
    }

    public function delete(int $id) {
        try {
            $this->lectorRepo->deactivate($id);
            $_SESSION['success'] = "Lector desactivado con éxito.";
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al desactivar lector: " . $e->getMessage();
        }
        $this->redirect("/lectores/list");
    }   
}