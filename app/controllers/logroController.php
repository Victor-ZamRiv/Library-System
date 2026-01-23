<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Contracts\ILogroRepository;
use App\Models\Entities\Logro;

class LogroController extends BaseController {

    private ILogroRepository $repo;

    public function __construct(ILogroRepository $repo) {
        $this->repo = $repo;
    }

    // Listar todos los logros
    public function index(): string {
        $logros = $this->repo->all();
        return $this->render('logros/list', ['logros' => $logros]);
    }

    // Mostrar detalles de un logro
    public function show(): string {
        $id = (int)$this->input('id', 0);
        $logro = $this->repo->find($id);

        if (!$logro) {
            http_response_code(404);
            return "Logro no encontrado";
        }

        return $this->render('logros/show', ['logro' => $logro]);
    }

    // Formulario de creación
    public function create(): string {
        return $this->render('event/achievement', []);
    }

    // Guardar nuevo logro
    public function store() {
        try {
            $logro = new Logro(
                null,
                $this->input('idAdmin', null),
                $this->input('descripcion'),
                $this->input('involucrados'),
                $this->input('fecha')
            );

            $idLogro = $this->repo->insert($logro);

            $_SESSION['success'] = "Logro registrado con éxito.";
            //$this->redirect("/logro/show?id=" . $idLogro);
            $this->redirect("/eventos");

        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al registrar logro: " . $e->getMessage();
            $_SESSION['old'] = $_POST;
            $this->redirect("/logro/create");
        }
    }

    // Formulario de edición
    public function edit(): string {
        $id = (int)$this->input('id', 0);
        $logro = $this->repo->find($id);

        if (!$logro) {
            http_response_code(404);
            return "Logro no encontrado";
        }

        return $this->render('logros/edit', ['logro' => $logro]);
    }

    // Actualizar logro
    public function update() {
        $id = (int)$this->input('id', 0);
        $logro = $this->repo->find($id);

        if (!$logro) {
            $_SESSION['error'] = "El logro no existe.";
            $this->redirect("/logros");
            return;
        }

        $logro->setDescripcion($this->input('descripcion', $logro->getDescripcion()));
        $logro->setInvolucrados($this->input('involucrados', $logro->getInvolucrados()));
        $logro->setFecha($this->input('fecha', $logro->getFecha()));

        if ($this->repo->update($logro)) {
            $_SESSION['success'] = "Logro actualizado correctamente.";
        } else {
            $_SESSION['error'] = "No se pudo actualizar el logro.";
        }

        $this->redirect("/logros/show?id=" . $id);
    }

    // Desactivar logro
    public function delete() {
        $id = (int)$this->input('id', 0);

        try {
            $this->repo->deactivate($id);
            $_SESSION['success'] = "Logro desactivado con éxito.";
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al desactivar logro: " . $e->getMessage();
        }

        $this->redirect("/logros");
    }
}
