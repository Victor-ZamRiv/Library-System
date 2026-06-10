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
use App\Models\Services\LibroUpdateService;
use App\Models\Services\AuditService;
use App\Models\Entities\Libro;
use App\Exceptions\RegistroLibroException;

class LibroController extends BaseController
{
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
        ILibroRepository $repo,
        IAutorRepository $autorRepo,
        LibroRegistrationService $libroRegistrationService,
        LibroSearchService $libroSearchService,
        libroDetailService $libroDetailsService,
        LibroUpdateService $libroUpdateService,
        IEditorialRepository $editorialRepo,
        IEjemplarRepository $ejemplarRepo,
        AuditService $auditService
    ) {
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

    // ==================== MÉTODOS AUXILIARES PRIVADOS ====================

    /**
     * Prepara un array plano con datos legibles para auditoría.
     * @param Libro $libro
     * @return array
     */
    private function prepararDatosAuditoria(Libro $libro): array
    {
        // Nombres de autores
        $autores = array_map(fn($a) => $a->getNombre(), $libro->getAutores());
        // Números de ejemplares
        $ejemplares = array_map(fn($e) => $e->getNumeroEjemplar(), $libro->getEjemplares());

        $editorial = $libro->getEditorial();
        $sala = $libro->getIdSala();
        $mapaSala = [
            'G' => 'Sala General',
            'R' => 'Sala Referencia',
            'SE' => 'Sala Estatal',
            'X' => 'Sala Infantil'
        ];

        return [
            'Título' => $libro->getTitulo(),
            'Área' => $libro->getIdArea(),
            'Cota' => $libro->getCota(),
            'Edición' => $libro->getEdicion(),
            'Ciudad' => $libro->getCiudad(),
            'ISBN' => $libro->getIsbn(),
            'Páginas' => $libro->getPaginas(),
            'Volumen' => $libro->getVolumen(),
            'Observaciones' => $libro->getObservaciones(),
            'Año Publicación' => $libro->getAnioPublicacion(),
            'Editorial' => $editorial ? $editorial->getNombre() : '',
            'Sala' => $mapaSala[$sala] ?? $sala,
            'Autores' => implode(', ', $autores),
            'Ejemplares' => implode(', ', $ejemplares),
            'Activo' => $libro->isActivo() ? 'Sí' : 'No',
        ];
    }
    private function getIdAdmin(): int
    {
        return $_SESSION['administrador']['id'] ?? 0;
    }

    /**
     * Obtiene el nombre del administrador actual para la auditoría.
     * @return string
     */
    private function getNombreAdmin(): string
    {
        $admin = $_SESSION['administrador'] ?? null;
        if ($admin && isset($admin['nombre_usuario'])) {
            return $admin['nombre_usuario'];
        }
        return 'Desconocido';
    }

    // ==================== MÉTODOS CRUD PRINCIPALES ====================

    public function index(): string
    {
        $pagina = (int) $this->input('page', 1);
        $porPagina = 12;
        $filtros = $_GET;
        $resultado = $this->libroSearchService->buscar($pagina, $porPagina, $filtros);
        return $this->render('catalog/catalog', [
            'libros' => $resultado['datos'],
            'paginacion' => [
                'actual' => $resultado['pagina'],
                'porPagina' => $resultado['porPagina'],
                'total' => $resultado['total'],
                'ultima' => $resultado['ultimaPagina']
            ],
            'filtros' => $filtros
        ]);
    }

    public function show(): string
    {
        $id = $this->input('id');
        if (!$id || !is_numeric($id)) {
            http_response_code(400);
            return "Código de libro inválido";
        }
        $libro = $this->libroDetailsService->obtenerDetallesLibro((int)$id);
        if (!$libro) {
            http_response_code(404);
            return "Libro no encontrado";
        }
        return $this->render('book/book-info', ['libro' => $libro]);
    }

    public function create(): string
    {
        return $this->render('book/book', []);
    }

    public function store()
    {
        try {
            $cota = $this->input('cota', '');
            if ($this->repo->existsCota($cota)) {
                throw new RegistroLibroException("La cota '{$cota}' ya está registrada en el sistema.");
            }
            $isbn = $this->input('isbn', '');
            if ($this->repo->existsISBN($isbn)) {
                throw new RegistroLibroException("El ISBN '{$isbn}' ya está registrado en el sistema.");
            }

            $autores[] = $_POST['autores'];
            $libro = $this->libroRegistrationService->registrar($_POST, $autores, $_POST['editorial'], (int)$_POST['ejemplares']);

            // Auditoría: INSERT
            $libroCompleto = $this->libroDetailsService->obtenerDetallesLibro($libro->getIdLibro());
            $nuevoArray = $this->prepararDatosAuditoria($libroCompleto);
            $this->auditService->registrarCambio(
                'historial_libro',
                $libro->getIdLibro(),
                $this->getIdAdmin(),  // ← cambio
                [],
                $nuevoArray,
                'INSERT'
            );

            $_SESSION['success'] = "Libro registrado con éxito";
            $this->redirect("/libros/show?id=" . $libro->getIdLibro());
        } catch (RegistroLibroException $e) {
            $_SESSION['old_data'] = $_POST;
            $_SESSION['error'] = $e->getMessage();
            $this->redirect("/libros/create");
        } catch (\Exception $e) {
            http_response_code(500);
            return $this->render('errors/error', [
                'mensaje' => "Ocurrió un error inesperado al registrar el libro.",
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public function option(): string
    {
        return $this->render('book/new-book', []);
    }

    public function newEdition(): string {
        $cota = $this->input('cota-reg', '');
        $libroExistente = $this->repo->findByCota($cota);
        if (!$libroExistente) {
            $_SESSION['error'] = "No se encontró un libro con la cota proporcionada.";
            $this->redirect("/libros/opcion");
        }
        $libro = $this->libroDetailsService->obtenerDetallesLibro($libroExistente->getIdLibro());
        return $this->render('book/book', ['libro' => $libro]);
    }

    public function storeNewEdition()
    {
        try {
            $cota = $this->input('cota', '');
            $libroExistente = $this->repo->findByCota($cota);
            if (!$libroExistente) {
                throw new RegistroLibroException("No se encontró un libro con la cota proporcionada.");
            }
            $_POST['cota'] = $cota . ' ' . $_POST['year'];
            $autores[] = $_POST['autores'];
            $libro = $this->libroRegistrationService->registrar($_POST, $autores, $_POST['editorial'], (int)$_POST['ejemplares']);

            // Auditoría: INSERT (nueva edición)
            $libroCompleto = $this->libroDetailsService->obtenerDetallesLibro($libro->getIdLibro());
            $nuevoArray = $this->prepararDatosAuditoria($libroCompleto);
            $this->auditService->registrarCambio(
                'historial_libro',
                $libro->getIdLibro(),
                $this->getIdAdmin(),  // ← cambio
                [],
                $nuevoArray,
                'INSERT'
            );

            $_SESSION['success'] = "Nueva edición registrada con éxito";
            $this->redirect("/libros/show?id=" . $libro->getIdLibro());
        } catch (RegistroLibroException $e) {
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
        $descatalogados = $this->ejemplarRepo->findDescatalogadosPorLibro((int)$id);
        return $this->render('book/book-edit', [
            'libro' => $libro,
            'descatalogados' => $descatalogados
        ]);
    }

    public function update()
    {
        $idLibro = (int)$this->input('idLibro', 0);
        try {
            if (!$idLibro) {
                throw new \Exception("ID de libro no proporcionado.");
            }

            // Obtener libro ANTES de modificar (con relaciones)
            $libroAntes = $this->libroDetailsService->obtenerDetallesLibro($idLibro);
            if (!$libroAntes) {
                throw new \Exception("El libro que intenta editar no existe.");
            }
            $oldArray = $this->prepararDatosAuditoria($libroAntes);

            // Validar cota
            $cota = $this->input('cota-reg', '');
            if ($this->repo->existsCota($cota, $idLibro)) {
                throw new RegistroLibroException("La cota '{$cota}' ya está asignada a otro libro.");
            }

            // Construir objeto libro con los nuevos datos
            $libro = $this->repo->find($idLibro);
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

            $autores = $this->input('autor-reg', []);
            if (!is_array($autores)) $autores = [$autores];
            $editorialNombre = $this->input('editorial', '');

            $ejemplaresDescatalogar = $this->input('ejemplares_descatalogar', []);
            $motivosDescatalogar   = $this->input('motivos_descatalogar', []);
            $nuevosEjemplares      = (int) $this->input('nuevos_ejemplares', 0);
            $estadosEjemplares     = $this->input('estado_ejemplar', []);

            // Concatenar observaciones por descatalogación
            $observacionesActuales = $libro->getObservaciones() ?? '';
            $nuevasObservaciones = $observacionesActuales;
            if (!empty($ejemplaresDescatalogar)) {
                foreach ($ejemplaresDescatalogar as $index => $idEjemplar) {
                    $motivo = $motivosDescatalogar[$index] ?? 'Sin motivo';
                    $ejemplar = $this->ejemplarRepo->find((int)$idEjemplar);
                    $numEjemplar = $ejemplar ? $ejemplar->getNumeroEjemplar() : $idEjemplar;
                    $nuevasObservaciones .= "\n Ejemplar #{$numEjemplar} descatalogado por: {$motivo}.";
                }
                $libro->setObservaciones(trim($nuevasObservaciones));
            }

            // Actualizar libro y ejemplares
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

            // Obtener libro DESPUÉS de modificar (con relaciones)
            $libroDespues = $this->libroDetailsService->obtenerDetallesLibro($idLibro);
            $newArray = $this->prepararDatosAuditoria($libroDespues);

            // Auditoría: UPDATE
            $this->auditService->registrarCambio(
                'historial_libro',
                $idLibro,
                $this->getIdAdmin(), 
                $oldArray,
                $newArray,
                'UPDATE'
            );

            $_SESSION['success'] = "Libro actualizado correctamente.";
            $this->redirect("/libros/show?id=" . $idLibro);
        } catch (RegistroLibroException $e) {
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
            // Obtener ejemplar y libro antes de modificar
            $ejemplar = $this->ejemplarRepo->find($idEjemplar);
            if (!$ejemplar) {
                throw new \Exception('Ejemplar no encontrado.');
            }
            $libro = $this->repo->find($idLibro);
            if (!$libro) {
                throw new \Exception('Libro no encontrado.');
            }

            // Obtener libro completo antes (para auditoría)
            $libroAntes = $this->libroDetailsService->obtenerDetallesLibro($idLibro);
            $oldArray = $this->prepararDatosAuditoria($libroAntes);

            // Eliminar línea de observación correspondiente
            $observacionesActuales = $libro->getObservaciones() ?? '';
            $numEjemplar = $ejemplar->getNumeroEjemplar();
            $patron = '/ Ejemplar #' . $numEjemplar . ' descatalogado por:.*?(?:\n|$)/';
            $nuevasObservaciones = preg_replace($patron, '', $observacionesActuales);
            $nuevasObservaciones = trim(preg_replace('/\n{2,}/', "\n", $nuevasObservaciones));
            $libro->setObservaciones($nuevasObservaciones);
            $this->repo->update($libro);

            // Reactivar ejemplar
            $this->ejemplarRepo->reactivar($idEjemplar);

            // Obtener libro después para auditoría
            $libroDespues = $this->libroDetailsService->obtenerDetallesLibro($idLibro);
            $newArray = $this->prepararDatosAuditoria($libroDespues);

            // Auditoría: UPDATE (se modificaron las observaciones)
            $this->auditService->registrarCambio(
                'historial_libro',
                $idLibro,
                $this->getIdAdmin(),
                $oldArray,
                $newArray,
                'UPDATE'
            );

            $_SESSION['success'] = 'Ejemplar reactivado y observación eliminada correctamente.';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
        }
        $this->redirect('/libros/edit?id=' . $idLibro);
    }

    public function delete(): string
    {
        $id = (int) $this->input('id');
        try {
            if (!$id) {
                throw new \Exception("ID inválido");
            }

            // Obtener libro completo antes de desactivar
            $libroAntes = $this->libroDetailsService->obtenerDetallesLibro($id);
            $oldArray = $this->prepararDatosAuditoria($libroAntes);

            if ($this->repo->deactivate($id)) {
                // Auditoría: DELETE (desactivación)
                $this->auditService->registrarCambio(
                    'historial_libro',
                    $id,
                    $this->getIdAdmin(),
                    $oldArray,
                    [],
                    'DELETE'
                );
                $_SESSION['success'] = "El libro ha sido desactivado con éxito.";
            } else {
                $_SESSION['error'] = "No se pudo desactivar el libro.";
            }
            $this->redirect("/libros");
        } catch (\Exception $e) {
            http_response_code(500);
            return $this->render('errors/error', [
                'mensaje' => "Ocurrió un error inesperado al eliminar el libro.",
                'detalle' => $e->getMessage()
            ]);
        }
        return '';
    }
}