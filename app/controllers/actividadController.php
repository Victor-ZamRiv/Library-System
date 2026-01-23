<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Contracts\IActividadRepository;
use App\Contracts\ILogroRepository;
use App\Models\Entities\Actividad;

class ActividadController extends BaseController {

    private IActividadRepository $repo;
    private ILogroRepository $logroRepo;

    public function __construct(IActividadRepository $repo, ILogroRepository $logroRepo) {
        $this->repo = $repo;
        $this->logroRepo = $logroRepo;
    }

    // Listar todas las actividades
    public function index(): string {
        $actividades = $this->repo->all();
        return $this->render('actividad/list', ['actividades' => $actividades]);
    }

    public function list(): string { 
        // Traer ambas colecciones 
        $actividades = $this->repo->all();
        $logros = $this->logroRepo->all(); 
        // Pasarlas juntas a la vista 
        return $this->render('event/event-list', [ 'actividades' => $actividades, 'logros' => $logros ]); 
    }

    // Mostrar detalles de una actividad
    public function show(): string {
        $id = (int)$this->input('id', 0);
        $actividad = $this->repo->find($id);

        if (!$actividad) {
            http_response_code(404);
            return "Actividad no encontrada";
        }

        return $this->render('actividad/show', ['actividad' => $actividad]);
    }

    // Formulario de creación
    public function create(): string {
        return $this->render('event/actividad', []);
    }

    // Guardar nueva actividad
    public function store() {
        try {
            $actividad = new Actividad(
                null,
                $this->input('idAdmin', null), // opcional si quieres vincular al admin
                $this->input('organizador'),
                $this->input('categoria'),
                $this->input('estado'),
                (int)$this->input('asistentes', 0),
                $this->input('descripcion'),
                $this->input('fecha')
            );

            $idActividad = $this->repo->insert($actividad);
            if (!$idActividad) {
                throw new \RuntimeException("No se pudo registrar la actividad");
            }
            $_SESSION['success'] = "Actividad registrada con éxito.";
            $this->redirect("/eventos");
            //$this->redirect("/actividades/show?id=" . $idActividad);

        }catch (\RuntimeException $e) {
            $_SESSION['old_data'] = $_POST;
            http_response_code(500);
            return $this->render('errors/error', [
                'mensaje' => "Ocurrió un error inesperado al registrar el libro.",
                'detalle' => $e->getMessage()
            ]);

        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al registrar actividad: " . $e->getMessage();
            $_SESSION['old_data'] = $_POST;
            $this->redirect("/actividades/create");
        }
    }

    // Formulario de edición
    public function edit(): string {
        $id = (int)$this->input('id', 0);
        $actividad = $this->repo->find($id);

        if (!$actividad) {
            http_response_code(404);
            return "Actividad no encontrada";
        }

        return $this->render('actividad/edit', ['actividad' => $actividad]);
    }

    // Actualizar actividad
    public function update() {
        $id = (int)$this->input('id', 0);
        $actividad = $this->repo->find($id);

        if (!$actividad) {
            $_SESSION['error'] = "La actividad no existe.";
            $this->redirect("/actividades");
            return;
        }

        $actividad->setOrganizador($this->input('organizador', $actividad->getOrganizador()));
        $actividad->setCategoria($this->input('categoria', $actividad->getCategoria()));
        $actividad->setEstado($this->input('estado', $actividad->getEstado()));
        $actividad->setAsistentes((int)$this->input('asistentes', $actividad->getAsistentes()));
        $actividad->setDescripcion($this->input('descripcion', $actividad->getDescripcion()));
        $actividad->setFecha($this->input('fecha', $actividad->getFecha()));

        if ($this->repo->update($actividad)) {
            $_SESSION['success'] = "Actividad actualizada correctamente.";
        } else {
            $_SESSION['error'] = "No se pudo actualizar la actividad.";
        }

        $this->redirect("/actividades/show?id=" . $id);
    }

    // Desactivar actividad
    public function delete() {
        $id = (int)$this->input('id', 0);

        try {
            $this->repo->deactivate($id);
            $_SESSION['success'] = "Actividad desactivada con éxito.";
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al desactivar actividad: " . $e->getMessage();
        }

        $this->redirect("/actividades");
    }
}