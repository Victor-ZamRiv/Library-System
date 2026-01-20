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

        $libro = $this->repo->find((int)$id);
        if (!$libro) {
            http_response_code(404);
            return "Libro no encontrado";
        }

        return $this->render('book/book-edit', ['libro' => $libro]);
    }

    public function update() {
        // 1. Capturar el ID que viene del formulario (hidden input)
            $idLibro = (int)$this->input('id_libro', 0);
            $cota = $this->input('cota', '');
            $editorialNombre = $this->input('editorial', '');
            $autores = $this->input('autores', []); // array de nombres
            $ejemplaresDescatalogar = $this->input('ejemplares_descatalogar', []); // array de IDs
            $nuevosEjemplares = (int)$this->input('nuevos_ejemplares', 0);


        try {
            if (!$idLibro) {
                throw new \Exception("ID de libro no proporcionado.");
            }

            // 2. Buscar el libro actual en la base de datos
            $libro = $this->repo->find((int)$idLibro);
            if (!$libro) {
                throw new \Exception("El libro que intenta editar no existe.");
            }

            // 3. Validar la Cota: que no exista en OTRO libro (excluyendo el actual)
            if ($this->repo->existsCota($cota, $idLibro)) {
                throw new \RuntimeException("La cota '{$cota}' ya está asignada a otro libro.");
            }

            // 4. Actualizar las propiedades del objeto Libro con los datos de $_POST
            $libro->setCota($cota);
            $libro->setTitulo($this->input('titulo', ''));
            $libro->setIsbn($this->input('isbn'));
            $libro->setAnioPublicacion($this->input('year'));
            $libro->setPaginas($this->input('paginas'));
            $libro->setIdEditorial((int)$this->input('editorial', 0));
            $libro->setIdSala($this->input('sala-reg'));
            $libro->setEdicion($this->input('edicion'));
            $libro->setVolumen($this->input('Volume'));
            $libro->setCiudad($this->input('ciudad'));
            $libro->setObservaciones($this->input('observaciones'));

            // 5. Llamar al método update dinámico del Repositorio
            $libroActualizado = $this->libroUpdateService->actualizar(
                $libro,
                $autores,
                $editorialNombre,
                $ejemplaresDescatalogar,
                $nuevosEjemplares
            );

            if (!$libroActualizado) {
                throw new \Exception("No se pudieron guardar los cambios en la base de datos.");
            }

            // 6. Todo salió bien: Mensaje de éxito y redirección a detalles
            $_SESSION['success'] = "Libro actualizado correctamente.";
            $this->redirect("/libros/show?id=" . $idLibro);

        } catch (\RuntimeException $e) {
            // Error de validación (Cota duplicada, etc.)
            $_SESSION['old_data'] = $_POST;
            $_SESSION['error'] = $e->getMessage();
            $this->redirect("/libros/edit?id=" . $idLibro);

        } catch (\Exception $e) {
            // Error técnico o inesperado
            $_SESSION['error'] = "Error al actualizar: " . $e->getMessage();
            $this->redirect("/libros/edit?id=" . $idLibro);
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