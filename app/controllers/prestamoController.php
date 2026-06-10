<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Contracts\IPrestamoRepository;
use App\Contracts\IEjemplarPrestamoRepository;
use App\Contracts\ILectorRepository;
use App\Contracts\IEjemplarRepository;
use App\Contracts\IMultaRepository;
use App\Contracts\ILibroRepository;
use App\Contracts\IConfiguracionRepository;
use App\Contracts\IPersonaRepository;
use App\Contracts\IAdministradorRepository;
use App\Models\Services\PrestamoRegistrationService;
use App\Models\Services\DevolucionService;
use App\Models\Services\PrestamoListService;
use App\Models\Services\PrestamoDetailService;
use App\Models\Services\PrestamoRenovacionService;
use App\Models\Services\AuditService;
use App\Models\Entities\Prestamo;

class PrestamoController extends BaseController
{
    private IPrestamoRepository $prestamoRepo;
    private IEjemplarPrestamoRepository $ejemplarPrestamoRepo;
    private ILectorRepository $lectorRepo;
    private IEjemplarRepository $ejemplarRepo;
    private IMultaRepository $multaRepo;
    private ILibroRepository $libroRepo;
    private IConfiguracionRepository $configRepository;
    private IPersonaRepository $personaRepo;
    private IAdministradorRepository $administradorRepo;
    private PrestamoRegistrationService $prestamoRegistrationService;
    private DevolucionService $devolucionService;
    private PrestamoListService $prestamoListService;
    private PrestamoDetailService $prestamoDetailService;
    private PrestamoRenovacionService $renovacionService;
    private AuditService $auditService;

    public function __construct(
        IPrestamoRepository $prestamoRepo,
        IEjemplarPrestamoRepository $ejemplarPrestamoRepo,
        ILectorRepository $lectorRepo,
        IEjemplarRepository $ejemplarRepo,
        IMultaRepository $multaRepo,
        ILibroRepository $libroRepo,
        IConfiguracionRepository $configRepository,
        IPersonaRepository $personaRepo,
        IAdministradorRepository $administradorRepo,
        PrestamoRegistrationService $prestamoRegistrationService,
        DevolucionService $devolucionService,
        PrestamoListService $prestamoListService,
        PrestamoDetailService $prestamoDetailService,
        PrestamoRenovacionService $renovacionService,
        AuditService $auditService
    ) {
        $this->prestamoRepo = $prestamoRepo;
        $this->ejemplarPrestamoRepo = $ejemplarPrestamoRepo;
        $this->lectorRepo = $lectorRepo;
        $this->ejemplarRepo = $ejemplarRepo;
        $this->multaRepo = $multaRepo;
        $this->libroRepo = $libroRepo;
        $this->configRepository = $configRepository;
        $this->personaRepo = $personaRepo;
        $this->administradorRepo = $administradorRepo;
        $this->prestamoRegistrationService = $prestamoRegistrationService;
        $this->devolucionService = $devolucionService;
        $this->prestamoListService = $prestamoListService;
        $this->prestamoDetailService = $prestamoDetailService;
        $this->renovacionService = $renovacionService;
        $this->auditService = $auditService;

        $this->authenticate();
        $this->middlewareRol(['Bibliotecario', 'Jefe de sala', 'Director'], 'préstamos');
    }

    // ==================== MÉTODOS AUXILIARES ====================

    private function getIdAdmin(): int
    {
        return $_SESSION['administrador']['id'] ?? 0;
    }

    /**
     * Prepara un array plano con datos legibles para auditoría.
     * @param Prestamo $prestamo
     * @return array
     */
    private function prepararDatosAuditoria(Prestamo $prestamo): array
    {
        // Obtener lector y su persona
        $lector = $this->lectorRepo->find($prestamo->getIdLector());
        $personaLector = $lector ? $this->personaRepo->find($lector->getIdPersona()) : null;

        // Obtener administrador (responsable)
        $admin = null;
        $nombreAdmin = 'Desconocido';
        if ($prestamo->getIdAdmin()) {
            $admin = $this->administradorRepo->find($prestamo->getIdAdmin());
            if ($admin && $admin->getPersona()) {
                $nombreAdmin = $admin->getPersona()->getNombre() . ' ' . $admin->getPersona()->getApellido();
            } elseif ($admin) {
                $nombreAdmin = $admin->getNombreUsuario();
            }
        }

        // Obtener ejemplares prestados y sus libros
        $idsEjemplares = $this->ejemplarPrestamoRepo->findByPrestamo($prestamo->getIdPrestamo());
        $ejemplaresInfo = [];
        foreach ($idsEjemplares as $idEj) {
            $ej = $this->ejemplarRepo->find($idEj);
            if ($ej) {
                $libro = $this->libroRepo->find($ej->getLibroId());
                $ejemplaresInfo[] = [
                    'ejemplar' => $ej->getNumeroEjemplar(),
                    'libro' => $libro ? $libro->getTitulo() : 'Desconocido',
                    'cota' => $libro ? $libro->getCota() : ''
                ];
            }
        }
        $ejemplaresTexto = implode(', ', array_map(fn($e) => "#{$e['ejemplar']} ({$e['cota']} - {$e['libro']})", $ejemplaresInfo));

        return [
            'ID Préstamo' => $prestamo->getIdPrestamo(),
            'Lector' => $personaLector ? $personaLector->getNombre() . ' ' . $personaLector->getApellido() . ' (Carnet: ' . $lector->getCarnet() . ')' : 'N/A',
            'Responsable' => $nombreAdmin,
            'Fecha Entrega' => $prestamo->getFechaEntrega(),
            'Fecha Devolución Estipulada' => $prestamo->getFechaRecepcionEstipulada(),
            'Fecha Devolución Real' => $prestamo->getFechaRecepcionReal() ?? 'Pendiente',
            'Renovaciones' => $prestamo->getRenovaciones(),
            'Estado Entrega' => $prestamo->getEstadoEntrega(),
            'Ejemplares' => $ejemplaresTexto ?: 'Ninguno',
            'Activo' => $prestamo->getActivo() ? 'Sí' : 'No',
        ];
    }

    // ==================== MÉTODOS DEL CONTROLADOR ====================

    public function create(): string
    {
        return $this->render('loan/loan');
    }

    public function checkLector(): void
    {
        header('Content-Type: application/json');
        $carnet = $this->input('carnet');
        $configuracion = $this->configRepository->getConfiguracion();
        if (!$configuracion) {
            echo json_encode(['success' => false, 'message' => 'No se pudo obtener la configuración del sistema.']);
            return;
        }
        if (!$carnet) {
            echo json_encode(['success' => false, 'message' => 'Carnet requerido']);
            return;
        }

        $lector = $this->lectorRepo->findByCarnet($carnet);
        if (!$lector) {
            echo json_encode(['success' => false, 'message' => 'Lector no encontrado']);
            return;
        }
        $lector->setPersona($this->personaRepo->find($lector->getIdPersona()));

        if ($lector->getEstado() !== 'Activo') {
            echo json_encode(['success' => false, 'message' => 'El lector no está activo']);
            return;
        }

        $multasPendientes = $this->multaRepo->findPendientesByLector($lector->getIdLector());
        if (!empty($multasPendientes)) {
            $total = array_sum(array_map(fn($m) => $m->getMonto(), $multasPendientes));
            echo json_encode([
                'success' => false,
                'message' => "El lector tiene multas pendientes (Total: $" . number_format($total, 2) . ")",
                'multas' => true
            ]);
            return;
        }

        $prestamosActivos = $this->prestamoRepo->findPrestamosActivosByLector($lector->getIdLector());
        $limite = $configuracion->getLimitePrestamosSimultaneos();
        if (count($prestamosActivos) >= $limite) {
            echo json_encode([
                'success' => false,
                'message' => "El lector ya tiene {$limite} préstamos activos (máximo permitido)"
            ]);
            return;
        }

        echo json_encode([
            'success' => true,
            'idLector' => $lector->getIdLector(),
            'nombreCompleto' => $lector->getPersona()->getNombre() . ' ' . $lector->getPersona()->getApellido(),
            'prestamosActivos' => count($prestamosActivos),
            'limite' => $limite
        ]);
    }

    public function checkLibro(): void
    {
        header('Content-Type: application/json');
        $cota = $this->input('cota');
        if (!$cota) {
            echo json_encode(['success' => false, 'message' => 'Cota requerida']);
            return;
        }

        $libro = $this->libroRepo->findByCota($cota);
        if (!$libro) {
            echo json_encode(['success' => false, 'message' => 'Libro no encontrado']);
            return;
        }

        $ejemplares = $this->ejemplarRepo->findByLibro($libro->getIdLibro());
        $disponibles = array_filter($ejemplares, fn($e) => $e->getEstado() === 'Disponible');

        if (empty($disponibles)) {
            echo json_encode([
                'success' => false,
                'message' => 'No hay ejemplares disponibles de este libro'
            ]);
            return;
        }

        $opciones = [];
        foreach ($disponibles as $ej) {
            $opciones[] = [
                'id' => $ej->getIdEjemplar(),
                'numero' => $ej->getNumeroEjemplar()
            ];
        }

        echo json_encode([
            'success' => true,
            'idLibro' => $libro->getIdLibro(),
            'titulo' => $libro->getTitulo(),
            'ejemplares' => $opciones
        ]);
    }

    public function store(): void
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        try {
            $idLector = (int) $this->input('idLector');
            $idsEjemplares = $this->input('ids_ejemplares');
            if (!is_array($idsEjemplares) || count($idsEjemplares) < 1 || count($idsEjemplares) > 3) {
                throw new \Exception("Seleccione entre 1 y 3 ejemplares.");
            }
            $idAdmin = $this->getIdAdmin();

            if (!$idLector || !$idsEjemplares || !$idAdmin) {
                throw new \Exception('Datos incompletos para registrar el préstamo.');
            }

            $prestamo = $this->prestamoRegistrationService->registrar($idLector, $idsEjemplares, $idAdmin);

            // Auditoría: INSERT
            $nuevoArray = $this->prepararDatosAuditoria($prestamo);
            $this->auditService->registrarCambio(
                'historial_prestamo',
                $prestamo->getIdPrestamo(),
                $idAdmin,
                [],
                $nuevoArray,
                'INSERT'
            );

            if ($isAjax) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Préstamo registrado con éxito',
                    'idPrestamo' => $prestamo->getIdPrestamo()
                ]);
            } else {
                $_SESSION['success'] = 'Préstamo registrado con éxito';
                $this->redirect('/prestamos');
            }
        } catch (\Exception $e) {
            if ($isAjax) {
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            } else {
                $_SESSION['error'] = $e->getMessage();
                $this->redirect('/prestamos/create');
            }
        }
    }

    public function previsualizarDevolucion(): void
    {
        header('Content-Type: application/json');
        $idPrestamo = (int) $this->input('id');
        if (!$idPrestamo) {
            echo json_encode(['success' => false, 'message' => 'ID de préstamo no proporcionado.']);
            return;
        }
        $resultado = $this->devolucionService->previsualizar($idPrestamo);
        echo json_encode($resultado);
    }

    public function devolver(): void
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        try {
            $idPrestamo = (int) $this->input('id');
            $idAdmin = $this->getIdAdmin();
            $estados = $this->input('estados');
            if (!is_array($estados) || empty($estados)) {
                throw new \Exception("Debe indicar el estado de cada ejemplar.");
            }

            // Obtener préstamo ANTES de la devolución
            $prestamoAntes = $this->prestamoRepo->find($idPrestamo);
            $oldArray = $prestamoAntes ? $this->prepararDatosAuditoria($prestamoAntes) : [];

            $resultado = $this->devolucionService->devolverPrestamoCompleto($idPrestamo, $idAdmin, $estados);

            if ($resultado['success']) {
                // Obtener préstamo DESPUÉS de la devolución
                $prestamoDespues = $this->prestamoRepo->find($idPrestamo);
                $newArray = $prestamoDespues ? $this->prepararDatosAuditoria($prestamoDespues) : [];
                $this->auditService->registrarCambio(
                    'historial_prestamo',
                    $idPrestamo,
                    $idAdmin,
                    $oldArray,
                    $newArray,
                    'UPDATE'
                );
            }

            if ($isAjax) {
                echo json_encode($resultado);
            } else {
                if ($resultado['multa']){
                    $_SESSION['info'] = $resultado['message'];
                } else {
                    $_SESSION[$resultado['success'] ? 'success' : 'error'] = $resultado['message'];
                }
                $this->redirect("/prestamos/show?id=" . $idPrestamo);
            }
        } catch (\Exception $e) {
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            } else {
                $_SESSION['error'] = $e->getMessage();
                $this->redirect("/prestamos/show?id=" . ($idPrestamo ?? 0));
            }
        }
    }

    public function renovar(): void
    {
        $idPrestamo = (int) $this->input('id');
        $idAdmin = $this->getIdAdmin();
        try {
            // Obtener préstamo ANTES de la renovación
            $prestamoAntes = $this->prestamoRepo->find($idPrestamo);
            $oldArray = $prestamoAntes ? $this->prepararDatosAuditoria($prestamoAntes) : [];

            $resultado = $this->renovacionService->renovar($idPrestamo, $idAdmin);

            if ($resultado['success']) {
                // Obtener préstamo DESPUÉS de la renovación
                $prestamoDespues = $this->prestamoRepo->find($idPrestamo);
                $newArray = $prestamoDespues ? $this->prepararDatosAuditoria($prestamoDespues) : [];
                $this->auditService->registrarCambio(
                    'historial_prestamo',
                    $idPrestamo,
                    $idAdmin,
                    $oldArray,
                    $newArray,
                    'UPDATE'
                );
            }

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($resultado);
            } else {
                $_SESSION[$resultado['success'] ? 'success' : 'error'] = $resultado['message'];
                $this->redirect('/prestamos/show?id=' . $idPrestamo);
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $this->redirect('/prestamos/show?id=' . ($idPrestamo ?? 0));
        }
    }

    public function index(): string
    {
        $pagina = (int) ($this->input('page') ?? 1);
        $criterio = $this->input('criterio') ?? '';
        $termino = trim($this->input('busqueda') ?? '');
        $porPagina = 10;

        $resultados = $this->prestamoListService->listarPaginado($pagina, $porPagina, $criterio, $termino);
        return $this->render('loan/loan-list', [
            'prestamos' => $resultados['datos'],
            'paginacion' => [
                'actual' => $resultados['pagina'],
                'porPagina' => $resultados['porPagina'],
                'total' => $resultados['total'],
                'ultima' => $resultados['ultimaPagina']
            ],
            'criterio' => $criterio,
            'termino' => $termino
        ]);
    }

    public function show(): string
    {
        $id = (int) $this->input('id');
        $detalles = $this->prestamoDetailService->obtenerDetalles($id);
        if (!$detalles) {
            http_response_code(404);
            $_SESSION['error'] = "Préstamo no encontrado.";
            $this->redirect('/prestamos');
        }
        return $this->render('loan/loan-info', $detalles);
    }
/*
    public function delete(): void
    {
        $id = (int) $this->input('id');
        try {
            $prestamoAntes = $this->prestamoRepo->find($id);
            $oldArray = $prestamoAntes ? $this->prepararDatosAuditoria($prestamoAntes) : [];

            if ($this->prestamoRepo->deActivate($id)) {
                $this->auditService->registrarCambio(
                    'historial_prestamo',
                    $id,
                    $this->getIdAdmin(),
                    $oldArray,
                    [],
                    'DELETE'
                );
                $_SESSION['success'] = "Préstamo desactivado con éxito.";
            } else {
                $_SESSION['error'] = "No se pudo desactivar el préstamo.";
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al desactivar préstamo: " . $e->getMessage();
        }
        $this->redirect('/prestamos');
    }
        */
} 