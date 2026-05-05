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
use App\Models\Services\PrestamoRegistrationService;
use App\Models\Services\DevolucionService;
use App\Models\Services\PrestamoListService;
use App\Models\Services\PrestamoDetailService;
use App\Models\Services\PrestamoRenovacionService;
use App\Models\Entities\Prestamo;
use App\Models\Entities\Configuracion;
use App\Models\Entities\Persona;

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
    private PrestamoRegistrationService $prestamoRegistrationService;
    private DevolucionService $devolucionService;
    private PrestamoListService $prestamoListService;
    private PrestamoDetailService $prestamoDetailService;
    private PrestamoRenovacionService $renovacionService;

    public function __construct(
        IPrestamoRepository $prestamoRepo,
        IEjemplarPrestamoRepository $ejemplarPrestamoRepo,
        ILectorRepository $lectorRepo,
        IEjemplarRepository $ejemplarRepo,
        IMultaRepository $multaRepo,
        ILibroRepository $libroRepo,
        IConfiguracionRepository $configRepository,
        IPersonaRepository $personaRepo,
        PrestamoRegistrationService $prestamoRegistrationService,
        DevolucionService $devolucionService,
        PrestamoListService $prestamoListService,
        PrestamoDetailService $prestamoDetailService,
        PrestamoRenovacionService $renovacionService
    ) {
        $this->prestamoRepo = $prestamoRepo;
        $this->ejemplarPrestamoRepo = $ejemplarPrestamoRepo;
        $this->lectorRepo = $lectorRepo;
        $this->ejemplarRepo = $ejemplarRepo;
        $this->multaRepo = $multaRepo;
        $this->libroRepo = $libroRepo;
        $this->configRepository = $configRepository;
        $this->personaRepo = $personaRepo;
        $this->prestamoRegistrationService = $prestamoRegistrationService;
        $this->devolucionService = $devolucionService;
        $this->prestamoListService = $prestamoListService;
        $this->prestamoDetailService = $prestamoDetailService;
        $this->renovacionService = $renovacionService;

        // Proteger todas las acciones (requiere autenticación)
        $this->authenticate();
        // Solo bibliotecarios y superiores pueden gestionar préstamos
        $this->middlewareRol(['Bibliotecario', 'Jefe_Sala', 'Director'], 'préstamos');
    }

    
    public function create(): string
    {
        return $this->render('loan/loan');
    }

    /**
     * Endpoint AJAX: Verificar lector y ver si puede realizar un préstamo
     */
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


        // Validar estado activo
        if ($lector->getEstado() !== 'Activo') {
            echo json_encode(['success' => false, 'message' => 'El lector no está activo']);
            return;
        }

        // Verificar multas pendientes
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

        // Verificar límite de préstamos activos
        $prestamosActivos = $this->prestamoRepo->findPrestamosActivosByLector($lector->getIdLector());
        $limite = $configuracion->getLimitePrestamosSimultaneos();
            if (count($prestamosActivos) >= $limite) {
            echo json_encode([
                'success' => false,
                'message' => "El lector ya tiene {$limite} préstamos activos (máximo permitido)"
            ]);
            return;
        }

        // Éxito
        echo json_encode([
            'success' => true,
            'idLector' => $lector->getIdLector(),
            'nombreCompleto' => $lector->getPersona()->getNombre() . ' ' . $lector->getPersona()->getApellido(),
            'prestamosActivos' => count($prestamosActivos),
            'limite' => $limite
        ]);
    }

    /**
     * Endpoint AJAX: valida la cota del libro y devuelve ejemplares disponibles
     */
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

        // Obtener ejemplares disponibles
        $ejemplares = $this->ejemplarRepo->findByLibro($libro->getIdLibro());
        $disponibles = array_filter($ejemplares, fn($e) => $e->getEstado() === 'Disponible');

        if (empty($disponibles)) {
            echo json_encode([
                'success' => false,
                'message' => 'No hay ejemplares disponibles de este libro'
            ]);
            return;
        }

        // Preparar lista para el selector
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

    /**
     * Endpoint final (AJAX o POST normal): registra el préstamo
     */
    public function store(): void
    {
        // Si se espera respuesta JSON (para llamada AJAX)
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        try {
            $idLector = (int) $this->input('idLector');
            $idsEjemplares = $this->input('ids_ejemplares'); // debe ser un array
                if (!is_array($idsEjemplares) || count($idsEjemplares) < 1 || count($idsEjemplares) > 3) {
                    throw new \Exception("Seleccione entre 1 y 3 ejemplares.");
            }
            $idAdmin = $_SESSION['administrador']['id'] ?? 0;

            if (!$idLector || !$idsEjemplares || !$idAdmin) {
                throw new \Exception('Datos incompletos para registrar el préstamo.');
            }

            // Usar el servicio de registro (que ya contiene validaciones y transacción)
            $prestamo = $this->prestamoRegistrationService->registrar($idLector, $idsEjemplares, $idAdmin);

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

        /**
     * Procesa la devolución completa de un préstamo.
     * Se espera recibir por POST el id del préstamo y opcionalmente un flag de daño.
     */

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
            $idAdmin = $_SESSION['administrador']['id'] ?? 0;
            
            // Recibir los estados de ejemplares: esperamos un array "estados" con formato [ idEjemplar => 'Disponible' o 'Dañado' ]
            $estados = $this->input('estados');
            if (!is_array($estados) || empty($estados)) {
                throw new \Exception("Debe indicar el estado de cada ejemplar.");
            }
            
            $resultado = $this->devolucionService->devolverPrestamoCompleto($idPrestamo, $idAdmin, $estados);
            
            if ($isAjax) {
                echo json_encode($resultado);
            } else {
                $_SESSION[$resultado['success'] ? 'success' : 'error'] = $resultado['message'];
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
        $idAdmin = $_SESSION['administrador']['id'] ?? 0;
        try {
            
            if(!$resultado = $this->renovacionService->renovar($idPrestamo, $idAdmin)) {
                throw new \Exception("Error al procesar la renovación.");
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

    /**
     * Opcional: mostrar detalles de un préstamo
     */
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
}