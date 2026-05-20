<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Entities\VisitantesRegistro;
use App\Models\Entities\ConsultaRegistro;
use App\Models\Services\VisitanteService;
use App\Models\Services\VisitanteEstadisticaService;

class VisitantesController extends BaseController
{
    private VisitanteService $visitanteService;
    private VisitanteEstadisticaService $estadisticaService;

    public function __construct(
        VisitanteService $visitanteService,
        VisitanteEstadisticaService $estadisticaService
    ) {
        $this->visitanteService = $visitanteService;
        $this->estadisticaService = $estadisticaService;
        $this->authenticate();
        $this->middlewareRol(['Jefe_Sala', 'Director'], 'registro de visitantes');
    }

    /**
     * Muestra el formulario de registro de visitas
     */
    public function create(): string
    {
        return $this->render('visitors/visitor');
    }

    /**
     * Guarda un nuevo registro de visitas y consultas
     */
    public function store(): void
    {
        $idAdmin = $_SESSION['administrador']['id'] ?? 0;
        $resultado = $this->visitanteService->registrar($_POST, $idAdmin);

        if ($resultado['success']) {
            $_SESSION['success'] = $resultado['message'];
            $this->redirect('/visitantes');
        } else {
            $_SESSION['error'] = $resultado['message'];
            $_SESSION['old'] = $_POST;
            $this->redirect('/visitantes/registro');
        }
    }

    /**
     * Página principal: listado, tarjetas, gráfico y modal (datos iniciales)
     */
    public function index(): string
    {
        // Período inicial (se puede cambiar vía GET, pero lo dejamos fijo a 'mes' para carga inicial)
        $periodo = $_GET['periodo'] ?? 'mes';
        $fechas = $this->estadisticaService->calcularRangoFechas($periodo);
        $fechaDesde = $fechas['inicio'];
        $fechaHasta = $fechas['fin'];

        // Filtros de fecha para la tabla (se pueden pasar por GET)
        $filtroDesde = $_GET['desde'] ?? $fechaDesde;
        $filtroHasta = $_GET['hasta'] ?? $fechaHasta;

        $pagina = (int)($_GET['page'] ?? 1);
        $porPagina = 10;

        // Datos para las tarjetas (niños, adolescentes, adultos)
        $totales = $this->estadisticaService->getTotalesGrupos($fechaDesde, $fechaHasta);
        $totalObras = $this->estadisticaService->getTotalObrasConsultadas($fechaDesde, $fechaHasta);

        // Datos para la tabla paginada
        $registros = $this->estadisticaService->listarRegistros($pagina, $porPagina, $filtroDesde, $filtroHasta);

        // Datos para el gráfico (mismo período)
        $datosGrafico = $this->estadisticaService->getDatosGrafico($periodo);

        // Datos para el modal (detalle por día)
        $datosModal = $this->estadisticaService->getDatosModal($periodo);

        return $this->render('visitors/visitor-list', [
            'totales' => $totales,
            'totalObras' => $totalObras,
            'registros' => $registros,
            'datosGrafico' => $datosGrafico,
            'datosModal' => $datosModal,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
            'periodo' => $periodo,
            'filtroDesde' => $filtroDesde,
            'filtroHasta' => $filtroHasta
        ]);
    }

    /**
     * Endpoint AJAX: actualiza el gráfico y las tarjetas según el período (semana, mes, trimestre)
     */
    public function datosGrafico(): void
    {
        header('Content-Type: application/json');
        $periodo = $_GET['periodo'] ?? 'mes';
        $fechas = $this->estadisticaService->calcularRangoFechas($periodo);
        $datosGrafico = $this->estadisticaService->getDatosGrafico($periodo);
        $totales = $this->estadisticaService->getTotalesGrupos($fechas['inicio'], $fechas['fin']);
        $totalObras = $this->estadisticaService->getTotalObrasConsultadas($fechas['inicio'], $fechas['fin']);
        echo json_encode([
            'grafico' => $datosGrafico,
            'totales' => $totales,
            'totalObras' => $totalObras
        ]);
    }

    /**
     * Endpoint AJAX: actualiza el modal de detalle según el período
     */
    public function datosModal(): void
    {
        header('Content-Type: application/json');
        $periodo = $_GET['periodo'] ?? 'mes';
        $datos = $this->estadisticaService->getDatosModal($periodo);
        echo json_encode($datos);
    }

    /**
     * Elimina (desactiva) un registro de visitas
     */
    /*
    public function delete(): void
    {
        $id = (int) $this->input('id');
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (!$id) {
            $this->responderError('ID no proporcionado', $isAjax);
            return;
        }

        try {
            $this->visitanteService->deactivate($id);  // Llama al servicio que a su vez usa el repositorio
            $this->responderExito('Registro eliminado correctamente', $isAjax);
        } catch (\Exception $e) {
            $this->responderError('Error al eliminar: ' . $e->getMessage(), $isAjax);
        }
    }

    // ==================== MÉTODOS AUXILIARES ====================
    private function responderExito(string $mensaje, bool $isAjax): void
    {
        if ($isAjax) {
            echo json_encode(['success' => true, 'message' => $mensaje]);
        } else {
            $_SESSION['success'] = $mensaje;
            $this->redirect('/visitantes');
        }
    }

    private function responderError(string $mensaje, bool $isAjax): void
    {
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => $mensaje]);
        } else {
            $_SESSION['error'] = $mensaje;
            $this->redirect('/visitantes');
        }
    }*/
}