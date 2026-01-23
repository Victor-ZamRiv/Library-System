<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Contracts\IPersonaRepository;
use App\Contracts\ILectorRepository;
use App\Models\Services\LectorRegistrationService;
use App\Models\Services\ListLectorService;
use App\Models\Entities\Persona;
use App\Models\Entities\Lector;

class LectorController extends BaseController {

    private IPersonaRepository $personaRepo;
    private ILectorRepository $lectorRepo;
    private LectorRegistrationService $lectorService;
    private ListLectorService $listLectorService;

    public function __construct(
        IPersonaRepository $personaRepo,
        ILectorRepository $lectorRepo,
        LectorRegistrationService $lectorService,
        ListLectorService $listLectorService
    ) {
        $this->personaRepo = $personaRepo;
        $this->lectorRepo = $lectorRepo;
        $this->lectorService = $lectorService;
        $this->listLectorService = $listLectorService;
    }

    // Listar todos los lectores
    public function list(): string {
        $lectores = $this->listLectorService->listar();
        return $this->render('reader/reader-list', ['lectores' => $lectores]);
    }

    public function search(): string {
        $input = $this->input('buscar', '');
        $lectores = $this->listLectorService->search($input);
        return $this->render('reader/reader-list', ['lectores' => $lectores]);
    }

    // Mostrar detalles de un lector
    public function show(): string {
        $id = (int)$this->input('id', 0);
        $lector = $this->lectorRepo->find($id);

        if (!$lector) {
            http_response_code(404);
            return "Lector no encontrado";
        }
        $persona = $this->personaRepo->find($lector->getIdPersona());
        $lector->setPersona($persona);
        //var_dump($lector);
        return $this->render('reader/reader-info', ['lector' => $lector]);
    }

    // Formulario de creación
    public function create(): string {
        return $this->render('reader/reader', []);
    }

    // Guardar nuevo lector
    public function store() {
        try {
            // Construir entidad Persona
            $persona = new Persona(
                null,
                $this->input('cedula'),
                $this->input('nombre-reg'),
                $this->input('apellido-reg'),
                $this->input('email'),
                $this->input('telefono-reg')
            );

            // Construir entidad Lector
            $lector = new Lector(
                null,
                0, // ID_Persona se asigna en el service
                $this->input('carnet-reg'),
                $this->input('sexo-reg'),
                $this->input('direccion-reg'),
                $this->input('profesion-reg'),
                $this->input('telefono-profesion-reg'),
                $this->input('direccion-profesion-reg'),
                $this->input('ref-personal-reg'),
                $this->input('telefono-ref-personal-reg'),
                $this->input('ref-legal-reg'),
                $this->input('telefono-ref-legal-reg'),
                'Activo',
                $this->input('vencimientoCarnet')
            );

            $idLector = $this->lectorService->registrar($persona, $lector);

            $_SESSION['success'] = "Lector registrado con éxito.";
            $this->redirect("/lectores/show?id=" . $idLector);

        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al registrar lector: " . $e->getMessage();
            $_SESSION['old_data'] = $_POST;
            $this->redirect("/lectores/create");
        }
    }

    // Formulario de edición
    public function edit(): string {
        $id = (int)$this->input('id', 0);
        $lector = $this->lectorRepo->find($id);

        if (!$lector) {
            http_response_code(404);
            return "Lector no encontrado";
        }

        return $this->render('lectores/edit', ['lector' => $lector]);
    }

    // Actualizar lector
    public function update() {
        $id = (int)$this->input('id', 0);
        $lector = $this->lectorRepo->find($id);

        if (!$lector) {
            $_SESSION['error'] = "El lector no existe.";
            $this->redirect("/lectores");
            return;
        }

        // Actualizar propiedades
        $lector->setCarnet($this->input('carnet', $lector->getCarnet()));
        $lector->setSexo($this->input('sexo', $lector->getSexo()));
        $lector->setDireccion($this->input('direccion', $lector->getDireccion()));
        $lector->setprofesion($this->input('profesion-reg', $lector->getprofesion()));
        $lector->setTelefonoprofesion($this->input('telefono-profesion-reg', $lector->getTelefonoprofesion()));
        $lector->setDireccionprofesion($this->input('direccion-profesion-reg', $lector->getDireccionprofesion()));
        $lector->setRefPersonal($this->input('refPersonal', $lector->getRefPersonal()));
        $lector->setRefPersonalTel($this->input('refPersonalTel', $lector->getRefPersonalTel()));
        $lector->setRefLegal($this->input('refLegal', $lector->getRefLegal()));
        $lector->setRefLegalTel($this->input('refLegalTel', $lector->getRefLegalTel()));
        $lector->setEstado($this->input('estado', $lector->getEstado()));
        $lector->setVencimientoCarnet($this->input('vencimientoCarnet', $lector->getVencimientoCarnet()));

        if ($this->lectorRepo->update($lector)) {
            $_SESSION['success'] = "Lector actualizado correctamente.";
        } else {
            $_SESSION['error'] = "No se pudo actualizar el lector.";
        }

        $this->redirect("/lectores/show?id=" . $id);
    }

    // Desactivar lector
    public function delete() {
        $id = (int)$this->input('id', 0);

        try {
            $this->lectorRepo->deactivate($id);
            $_SESSION['success'] = "Lector desactivado con éxito.";
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al desactivar lector: " . $e->getMessage();
        }

        $this->redirect("/lectores");
    }
}
