<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Contracts\ILibroRepository;
use App\Contracts\IAutorRepository;
use App\Contracts\IEditorialRepository;
use App\Contracts\IEjemplarRepository;
use App\Models\Services\LibroRegistrationService;
use App\Models\Services\LibroSearchService;
use App\Models\Services\libroDetailService;
use App\Models\Entities\Libro;
use App\Models\Entities\Autor;
use App\Models\Services\LibroUpdateService;
use App\Models\Services\AuditService;


class LibroController extends BaseController {
    private ILibroRepository $repo;
    private IAutorRepository $autorRepo;
    private LibroRegistrationService $libroRegistrationService;
    private LibroSearchService $libroSearchService;
    private libroDetailService $libroDetailsService;
    private LibroUpdateService $libroUpdateService;
    private IEditorialRepository $editorialRepo;
    private IEjemplarRepository $ejemplarRepo;
    private AuditService $auditService;

    public function __construct(
        ILibroRepository $repo, IAutorRepository $autorRepo, LibroRegistrationService $libroRegistrationService, 
        LibroSearchService $libroSearchService, libroDetailService $libroDetailsService, 
        LibroUpdateService $libroUpdateService, IEditorialRepository $editorialRepo, IEjemplarRepository $ejemplarRepo, AuditService $auditService)
        {
        $this->repo = $repo;
        $this->autorRepo = $autorRepo;
        $this->libroRegistrationService = $libroRegistrationService;
        $this->libroSearchService = $libroSearchService;
        $this->libroDetailsService = $libroDetailsService;
        $this->libroUpdateService = $libroUpdateService;
        $this->editorialRepo = $editorialRepo;
        $this->ejemplarRepo = $ejemplarRepo;
        $this->auditService = $auditService;
        $this->authenticate();
    }

    public function index(): string
    {
        $pagina = (int) $this->input('page', 1);
        $porPagina = 12;
        $filtros = $_GET;
        
        $resultado = $this->libroSearchService->buscar($pagina, $porPagina, $filtros);
        
        return $this->render('catalog/catalog', [
            'libros' => $resultado['datos'],      // solo las entidades
            'paginacion' => [
                'actual' => $resultado['pagina'],
                'porPagina' => $resultado['porPagina'],
                'total' => $resultado['total'],
                'ultima' => $resultado['ultimaPagina']
            ],
            'filtros' => $filtros
        ]);
    }

    /*public function search(): string {        
        $libros = $this->libroSearchService->buscar($_GET);
        foreach ($libros as $libro) {
            $autores = $this->autorRepo->getAutoresLibro($libro->getIdLibro());
            $libro->setAutores($autores);
        }
        return $this->render('catalog/catalog', ['libros' => $libros]);
    }*/

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

            $isbn = $this->input('isbn', '');
            if ($this->repo->existsISBN($isbn)) {
                throw new \App\Exceptions\RegistroLibroException("El ISBN '{$isbn}' ya está registrado en el sistema.");
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

    public function option(): string {
        return $this->render('book/new-book', []);
    }

    public function newEdition(): string {
        $cota = $this->input('cota-reg', '');
        $libroExistente = $this->repo->findByCota($cota);
        $libro=$this->libroDetailsService->obtenerDetallesLibro($libroExistente->getIdLibro());
        if (!$libroExistente) {
            $_SESSION['error'] = "No se encontró un libro con la cota proporcionada.";
            $this->redirect("/libros/opcion");
        }
        return $this->render('book/book', ['libro' => $libro]);
    }

    public function storeNewEdition() {
        try {
            $cota = $this->input('cota', '');
            $libroExistente = $this->repo->findByCota($cota);
            if (!$libroExistente) {
                throw new \App\Exceptions\RegistroLibroException("No se encontró un libro con la cota proporcionada.");
            }
            $_POST['cota'] = $cota . ' ' . $_POST['year'];
            $autores [] = $_POST['autores'];
            $libro = $this->libroRegistrationService->registrar($_POST, $autores, $_POST['editorial'], (int)$_POST['ejemplares']);
            $_SESSION['success'] = "Libro registrado con éxito";
            $this->redirect("/libros/show?id=" . $libro->getIdLibro());
        } catch (\App\Exceptions\RegistroLibroException $e) {
            $_SESSION['old_data'] = $_POST; 
            $_SESSION['error'] = $e->getMessage();
            $this->redirect("/libros/opcion");
        } catch (\Exception $e) {
            http_response_code(500);
            return $this->render('errors/error', [
                'mensaje' => "Ocurrió un error inesperado al registrar la nueva edición.",
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public function edit(): string
    {
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

        // Obtener ejemplares descatalogados (opcional, para el modal)
        $descatalogados = $this->ejemplarRepo->findDescatalogadosPorLibro((int)$id);

        return $this->render('book/book-edit', [
            'libro' => $libro,
            'descatalogados' => $descatalogados
        ]);
    }
    
    /**
     * Actualiza un libro existente.
     */
    public function update()
    {
        $idLibro = (int) $this->input('idLibro', 0);

        try {
            if (!$idLibro) {
                throw new \Exception("ID de libro no proporcionado.");
            }

            // Obtener el libro actual (antes de modificarlo) para auditoría
            $libroAntes = $this->repo->find($idLibro);
            if (!$libroAntes) {
                throw new \Exception("El libro que intenta editar no existe.");
            }
            $oldArray = $libroAntes->toArray();

            // Validar cota (unicidad)
            $cota = $this->input('cota-reg', '');
            if ($this->repo->existsCota($cota, $idLibro)) {
                throw new \App\Exceptions\RegistroLibroException("La cota '{$cota}' ya está asignada a otro libro.");
            }

            // Crear objeto libro con los nuevos datos (sin persistir aún)
            $libro = $this->repo->find($idLibro); // ya lo tenemos, lo reusamos
            $libro->setIdSala($this->input('sala-reg', $libro->getIdSala()));
            $libro->setCota($cota);
            $libro->setTitulo($this->input('titulo-reg', $libro->getTitulo()));
            $libro->setIsbn($this->input('isbn', $libro->getIsbn()));
            $libro->setAnioPublicacion($this->input('year-reg', $libro->getAnioPublicacion()));
            $libro->setPaginas($this->input('paginas-reg', $libro->getPaginas()));
            $libro->setEdicion($this->input('edicion-reg', $libro->getEdicion()));
            $libro->setVolumen($this->input('volumen-reg', $libro->getVolumen()));
            $libro->setCiudad($this->input('ciudad-reg', $libro->getCiudad()));
            $libro->setObservaciones($this->input('observaciones-reg', $libro->getObservaciones()));

            // Autores y editorial
            $autores = $this->input('autor-reg', []);
            if (!is_array($autores)) $autores = [$autores];
            $editorialNombre = $this->input('editorial', '');

            // Ejemplares: descatalogar, nuevos, cambios de estado
            $ejemplaresDescatalogar = $this->input('ejemplares_descatalogar', []);
            $motivosDescatalogar   = $this->input('motivos_descatalogar', []);
            $nuevosEjemplares      = (int) $this->input('nuevos_ejemplares', 0);
            $estadosEjemplares     = $this->input('estado_ejemplar', []); // [id => estado]

            // Concatenar observaciones por descatalogación (solo si hay)
            $observacionesActuales = $libro->getObservaciones() ?? '';
            $nuevasObservaciones = $observacionesActuales;
            if (!empty($ejemplaresDescatalogar)) {
                foreach ($ejemplaresDescatalogar as $index => $idEjemplar) {
                    $motivo = $motivosDescatalogar[$index] ?? 'Sin motivo';
                    $ejemplar = $this->ejemplarRepo->find((int)$idEjemplar);
                    $numEjemplar = $ejemplar ? $ejemplar->getNumeroEjemplar() : $idEjemplar;
                    $nuevasObservaciones .= "\n- Ejemplar #{$numEjemplar} descatalogado por: {$motivo}.";
                }
                $libro->setObservaciones(trim($nuevasObservaciones));
            }

            // Actualizar libro (llama al servicio que maneja transacción)
            $libroActualizado = $this->libroUpdateService->actualizar(
                $libro,
                $autores,
                $editorialNombre,
                $ejemplaresDescatalogar,
                $nuevosEjemplares,
                $estadosEjemplares
            );

            if (!$libroActualizado) {
                throw new \Exception("No se pudieron guardar los cambios en la base de datos.");
            }

            // Obtener el libro después de la actualización para auditoría
            $libroDespues = $this->repo->find($idLibro);
            $newArray = $libroDespues->toArray();

            // Registrar auditoría (si tienes AuditService inyectado)
            if (isset($this->auditService)) {
                $this->auditService->registrarCambio(
                    'historial_libro',
                    $idLibro,
                    $_SESSION['administrador']['id'],
                    $oldArray,
                    $newArray,
                    'UPDATE'
                );
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

    public function reactivarEjemplar(): void
    {
        $idEjemplar = (int) $this->input('id');
        $idLibro = (int) $this->input('id_libro');

        try {
            // 1. Obtener el ejemplar para saber su número
            $ejemplar = $this->ejemplarRepo->find($idEjemplar);
            if (!$ejemplar) {
                throw new \Exception('Ejemplar no encontrado.');
            }

            // 2. Obtener el libro
            $libro = $this->repo->find($idLibro);
            if (!$libro) {
                throw new \Exception('Libro no encontrado.');
            }

            $libroOld = $this->libroDetailsService->obtenerDetallesLibro($idLibro);

            // 3. Eliminar la línea de observación correspondiente
            $observacionesActuales = $libro->getObservaciones() ?? '';
            $numEjemplar = $ejemplar->getNumeroEjemplar();
            
            // Buscar líneas que empiecen con "- Ejemplar #{$numEjemplar} descatalogado por:"
            $patron = '/- Ejemplar #' . $numEjemplar . ' descatalogado por:.*?(?:\n|$)/';
            $nuevasObservaciones = preg_replace($patron, '', $observacionesActuales);
            // Limpiar posibles saltos de línea dobles
            $nuevasObservaciones = trim(preg_replace('/\n{2,}/', "\n", $nuevasObservaciones));
            
            $libro->setObservaciones($nuevasObservaciones);
            $this->repo->update($libro);
            $libroNew = $this->libroDetailsService->obtenerDetallesLibro($idLibro);
            // Registrar auditoría por la reactivación del ejemplar
            if (isset($this->auditService)) {
                $this->auditService->registrarCambio(
                    'historial_libro',
                    $idLibro,
                    $_SESSION['administrador']['id'],
                    $libroOld->toArray(),
                    $libroNew->toArray(),
                    'REACTIVAR_EJEMPLAR'
                );
            }

            // 4. Reactivar el ejemplar
            $this->ejemplarRepo->reactivar($idEjemplar);

            $_SESSION['success'] = 'Ejemplar reactivado y observación eliminada correctamente.';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
        }
        $this->redirect('/libros/edit?id=' . $idLibro);
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