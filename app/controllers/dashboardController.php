<?php
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\Services\IndicadorService;

class DashboardController extends BaseController {

    private IndicadorService $indicadorService;

    public function __construct(IndicadorService $indicadorService) {
        $this->indicadorService = $indicadorService;
        $this->authenticate();
        $this->middlewareRol(['Director', 'Jefe de sala'], 'Dashboard');
    }

    /**
     * Carga inicial del dashboard: pasa todos los indicadores estáticos y datos de tablas a la vista.
     */
    public function index(): string
    {
        // ========== INDICADORES GLOBALES (estáticos) ==========
        $cobertura = $this->indicadorService->getCoberturaUsuarios();
        $promedioConsultas = $this->indicadorService->getPromedioConsultasMensuales();
        $tasaCumplimiento = $this->indicadorService->getTasaCumplimientoPlazos();
        $rotacion = $this->indicadorService->getRotacionColeccion();
        $ocupacion = $this->indicadorService->getPorcentajeOcupacionSalas();
        $estadoFisico = $this->indicadorService->getPorcentajeEjemplaresBuenEstado();
        $asistenciaEstatal = $this->indicadorService->getPorcentajeAsistentesSalaEstatal();
        $coleccionEstatal = $this->indicadorService->getPorcentajeColeccionEstatal();
        $razonReferencia = $this->indicadorService->getRazonConsultasReferencia();
        $participacionActividades = $this->indicadorService->getPorcentajeParticipacionActividades();
        $segmentosCobertura = $this->indicadorService->getSegmentosCobertura();

        // ========== DATOS DESGLOSADOS PARA MODALES ==========
        $rotacionCategorias = $this->indicadorService->getRotacionPorCategorias();
        $estadoFisicoPorSalas = $this->indicadorService->getEstadoFisicoPorSalas();
        $asistenciaEstatalPorTipo = $this->indicadorService->getAsistenciaEstatalPorTipo();
        $necesidadesColeccion = $this->indicadorService->getNecesidadesColeccionPorSalas();

        // Pasamos todos los datos a la vista
        return $this->render('home/home', [
            'cobertura' => $cobertura,
            'promedioConsultas' => $promedioConsultas,
            'tasaCumplimiento' => $tasaCumplimiento,
            'rotacion' => $rotacion,
            'ocupacion' => $ocupacion,
            'segmentosCobertura' => $segmentosCobertura,
            'estadoFisico' => $estadoFisico,
            'asistenciaEstatal' => $asistenciaEstatal,
            'coleccionEstatal' => $coleccionEstatal,
            'razonReferencia' => $razonReferencia,
            'participacionActividades' => $participacionActividades,
            'rotacionCategorias' => $rotacionCategorias,
            'estadoFisicoPorSalas' => $estadoFisicoPorSalas,
            'asistenciaEstatalPorTipo' => $asistenciaEstatalPorTipo,
            'necesidadesColeccion' => $necesidadesColeccion,
        ]);
    }

    // ================= ENDPOINTS AJAX PARA GRÁFICOS DINÁMICOS =================

    /**
     * Endpoint: /dashboard/cobertura?periodo=... (ejemplo, aunque cobertura no varía por período)
     */
    public function ajaxCobertura(): void
    {
        header('Content-Type: application/json');
        $periodo = $_GET['periodo'] ?? 'mes';
        $valor = $this->indicadorService->getCoberturaUsuarios();
        $claseColor = $this->getClaseColor($valor);
        echo json_encode([
            'valor' => $valor,
            'estado' => 'Cobertura calculada en tiempo real',
            'clase_color' => $claseColor
        ]);
    }

    /**
     * Endpoint: /dashboard/consultas?periodo=semana|mes|trimestre
     */
    public function ajaxConsultas(): void
    {
        header('Content-Type: application/json');
        $periodo = $_GET['periodo'] ?? 'mes';
        $datos = $this->indicadorService->getSeriesConsultas($periodo);
        echo json_encode($datos);
    }

    /**
     * Endpoint: /dashboard/cumplimiento?periodo=semana|mes|trimestre
     */
    public function ajaxCumplimiento(): void
    {
        header('Content-Type: application/json');
        $periodo = $_GET['periodo'] ?? 'mes';
        $datos = $this->indicadorService->getSeriesCumplimiento($periodo);
        echo json_encode($datos);
    }

    /**
     * Endpoint: /dashboard/ocupacion?periodo=semana|mes|trimestre
     */
    public function ajaxOcupacion(): void
    {
        header('Content-Type: application/json');
        $periodo = $_GET['periodo'] ?? 'mes';
        $datos = $this->indicadorService->getSeriesOcupacion($periodo);
        echo json_encode($datos);
    }

    /**
     * Auxiliar para determinar clase de color según valor.
     * Puedes ajustar los rangos según la tabla de semáforo.
     */
    private function getClaseColor(float $valor): string
    {
        if ($valor >= 70) return 'success';
        if ($valor >= 30) return 'warning';
        return 'danger';
    }
}