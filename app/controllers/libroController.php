<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Contracts\ILibroRepository;
use App\Models\Services\LibroRegistrationService;
use App\Models\Services\LibroSearchService;
use App\Models\Services\libroDetailService;
use App\Models\Entities\Libro;
use App\Models\Services\LibroUpdateService;

class LibroController extends BaseController {
    private ILibroRepository $repo;
    private LibroRegistrationService $libroRegistrationService;
    private LibroSearchService $libroSearchService;
    private libroDetailService $libroDetailsService;
    private LibroUpdateService $libroUpdateService;

    public function __construct(
        ILibroRepository $repo, LibroRegistrationService $libroRegistrationService, 
        LibroSearchService $libroSearchService, libroDetailService $libroDetailsService, 
        LibroUpdateService $libroUpdateService)
        {
        $this->repo = $repo;
        $this->libroRegistrationService = $libroRegistrationService;
        $this->libroSearchService = $libroSearchService;
        $this->libroDetailsService = $libroDetailsService;
        $this->libroUpdateService = $libroUpdateService;
    }

    public function index(): string {
        $libros = $this->repo->all();
        return $this->render('catalog/catalog', ['libros' => $libros]);
    }

    public function show(): string {
        $id = $this->input('id');
        if (!$id || !is_numeric($id)) {
            http_response_code(400);
            return "Codigo de libro inválido";
        }

        $libro = $this->libroDetailsService->obtenerDetallesLibro((int)$id);
        if (!$libro) {
            http_response_code(404);
            return "Libro no encontrado";
        }
        //var_dump($libro);
        return $this->render('book/book-info', ['libro' => $libro]);
    }

    public function create(): string {
        return $this->render('book/book', []);
    }

    public function store() {
        try {
            $cota = $this->input('cota', '');
            // Validar que la cota no exista ya
            if ($this->repo->existsCota($cota)) {
                throw new \App\Exceptions\RegistroLibroException("La cota '{$cota}' ya está registrada en el sistema.");
            }

            $autores [] = $_POST['autores'];
            $libro = $this->libroRegistrationService->registrar($_POST, $autores, $_POST['editorial'], (int)$_POST['ejemplares']);
            $_SESSION['success'] = "Libro registrado con éxito";
            $this->redirect("/libros/show?id=" . $libro->getIdLibro());
            //var_dump($libro);
        } catch (\App\Exceptions\RegistroLibroException $e) {
            // guardar datos viejos en sesión
            $_SESSION['old_data'] = $_POST; 
            // Guardar el mensaje de error
            $_SESSION['error'] = $e->getMessage();
            /*var_dump($libro);
            echo $this->render('book/error', [
            'mensaje' => $e->getMessage(),
            'detalle' => $e->getPrevious() ? $e->getPrevious()->getMessage() : null
            ]);*/
            $this->redirect("/libros/create");
        } catch (\Exception $e) {
            http_response_code(500);
            return $this->render('errors/error', [
                'mensaje' => "Ocurrió un error inesperado al registrar el libro.",
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public function edit(): string {
        $id = $this->input('id');
        if (!$id || !is_numeric($id)) {
            http_response_code(400);
            return "ID inválido";
        }

        $libro = $this->libroDetailsService->obtenerDetallesLibro((int)$id);
        if (!$libro) {
            http_response_code(404);
            return "Libro no encontrado";
        }

        return $this->render('book/book-edit', ['libro' => $libro]);
    }

    
    public function update() {
        $idLibro = (int)$this->input('idLibro', 0);

        try {
            if (!$idLibro) {
                throw new \Exception("ID de libro no proporcionado.");
            }

            $libro = $this->repo->find($idLibro);
            if (!$libro) {
                throw new \Exception("El libro que intenta editar no existe.");
            }

            // Validar cota
            $cota = $this->input('cota-reg', '');
            if ($this->repo->existsCota($cota, $idLibro)) {
                throw new \App\Exceptions\RegistroLibroException("La cota '{$cota}' ya está asignada a otro libro.");
            }

            // Actualizar propiedades con los nombres correctos de los inputs
            $libro->setIdSala($this->input('sala-reg', $libro->getIdSala()));
            $libro->setCota($cota);
            $libro->setTitulo($this->input('titulo-reg', $libro->getTitulo()));
            $libro->setIsbn($this->input('isbn', $libro->getIsbn()));
            $libro->setAnioPublicacion($this->input('year-reg', $libro->getAnioPublicacion()));
            $libro->setPaginas($this->input('paginas-reg', $libro->getPaginas()));
            $libro->setEdicion($this->input('edicion-reg', $libro->getEdicion()));
            $libro->setVolumen($this->input('volumen-reg', $libro->getVolumen())); // corrige el name en la vista
            $libro->setCiudad($this->input('ciudad-reg', $libro->getCiudad()));
            $libro->setObservaciones($this->input('observaciones', $libro->getObservaciones()));

            // Autores y editorial
            $autores = $this->input('autor-reg', []); // ajusta a array si permites múltiples
            $editorialNombre = $this->input('editorial', '');

            // Ejemplares
            $ejemplaresDescatalogar = $this->input('ejemplares_descatalogar', []);
            $nuevosEjemplares = (int)$this->input('nuevos_ejemplares', 0);
            $estadosEjemplares = $this->input('estado_ejemplar', []); // array asociativo [id => estado]
            /*    var_dump($estadosEjemplares);
                var_dump($ejemplaresDescatalogar);
                var_dump($_POST);
            throw new \Exception("Prueba de error antes de actualizar.");*/

            $libroActualizado = $this->libroUpdateService->actualizar(
                $libro,
                (array)$autores,
                $editorialNombre,
                (array)$ejemplaresDescatalogar,
                $nuevosEjemplares,
                (array)$estadosEjemplares
            );

            if (!$libroActualizado) {
                throw new \Exception("No se pudieron guardar los cambios en la base de datos.");
            }

            $_SESSION['success'] = "Libro actualizado correctamente.";
            $this->redirect("/libros/show?id=" . $idLibro);

        } catch (\App\Exceptions\RegistroLibroException $e) {
            $_SESSION['old_data'] = $_POST;
            $_SESSION['error'] = $e->getMessage();
            $this->redirect("/libros/edit?id=" . $idLibro);
        } catch (\Exception $e) {
            http_response_code(500);
            return $this->render('errors/error', [
                'mensaje' => "Ocurrió un error inesperado al actualizar el libro.",
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public function delete(): string {
        try {
            $id = $this->input('id');
            if (!$id || !is_numeric($id)) {
                http_response_code(400);
                return "ID inválido";
            }

            if ($this->repo->deactivate((int)$id)) {
                $_SESSION['success'] = "El libro ha sido desactivado con éxito.";
            } else {
                $_SESSION['error'] = "No se pudo desactivar el libro.";
            }

            $this->redirect("/libros");
            return '';
        } catch (\Exception $e) {
            http_response_code(500);
            return $this->render('errors/error', [
                'mensaje' => "Ocurrió un error inesperado al eliminar el libro.",
                'detalle' => $e->getMessage()
            ]);
        }
    }
}