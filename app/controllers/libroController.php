<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Repositories\LibroRepository;
use App\Models\Services\LibroRegistrationService;
use App\Models\Services\LibroSearchService;
use App\Models\Entities\Libro;

class LibroController extends BaseController {
    private LibroRepository $repo;
    private LibroRegistrationService $libroRegistrationService;
    private LibroSearchService $libroSearchService;

    public function __construct(LibroRepository $repo, LibroRegistrationService $libroRegistrationService, LibroSearchService $libroSearchService) {
        $this->repo = $repo;
        $this->libroRegistrationService = $libroRegistrationService;
        $this->libroSearchService = $libroSearchService;
    }

    public function index(): string {
        $libros = $this->repo->all();
        return $this->render('catalog/catalog', ['libros' => $libros]);
    }

    public function show(): string {
        $id = $this->input('id');
        if (!$id || !is_numeric($id)) {
            http_response_code(400);
            return "ID inválido";
        }

        $libro = $this->repo->find((int)$id);
        if (!$libro) {
            http_response_code(404);
            return "Libro no encontrado";
        }

        return $this->render('libros/show', ['libro' => $libro]);
    }

    public function create(): string {
        return $this->render('libros/create');
    }

    public function store() {
    try {
        $libro = $this->libroRegistrationService->registrar($_POST, $_POST['autores'], $_POST['editorial'], (int)$_POST['numEjemplares']);
        if ($libro) {
            $this->redirect('/libros');
        } else {
            echo $this->render('libros/error', ['mensaje' => 'No se pudo registrar el libro']);
        }
    } catch (\RuntimeException $e) {
        echo $this->render('libros/error', ['mensaje' => $e->getMessage()]);
    }
}

    public function update(): string {
        $id = $this->input('id');
        $titulo = $this->input('titulo', '');

        if (!$id || !is_numeric($id) || trim($titulo) === '') {
            http_response_code(400);
            return "Datos inválidos";
        }

        $libro = new Libro((int)$id, trim($titulo));
        $this->repo->update($libro);
        $this->redirect("/libros/show?id=$id");
        return "";
    }

    public function destroy(): string {
        $id = $this->input('id');
        if (!$id || !is_numeric($id)) {
            http_response_code(400);
            return "ID inválido";
        }

        $this->repo->delete((int)$id);
        $this->redirect("/libros");
        return '';
    }
}