<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Services\ReporteOperativoService;

class ReportController extends BaseController
{
    private ReporteOperativoService $reporteService;

    public function __construct(ReporteOperativoService $reporteService)
    {
        $this->reporteService = $reporteService;
        $this->authenticate();
        // Puedes ajustar los roles permitidos según tu política
        $this->middlewareRol(['Director', 'Jefe de sala'], 'reportes');
    }

    /**
     * Muestra el reporte operativo con los datos filtrados por período y sala.
     * @param string|null $periodo (semana, mes, trimestre) - por defecto mes
     * @param string|null $sala (general, sala_general, sala_referencia, sala_estatal, sala_infantil) - por defecto general
     */
    public function index(): string
    {
        $periodo = $this->input('periodo', 'mes');
        $sala = $this->input('sala', 'general');

        // Calcular rango de fechas
        $rango = $this->reporteService->calcularRango($periodo);

        // Mapear el parámetro sala al ID_Sala real (o null para general)
        $salaId = $this->mapearSalaId($sala);

        // Datos generales (totales superiores) que no dependen de la sala (son globales)
        $totales = $this->reporteService->getTotalesPeriodo($rango);
        $actividades = $this->reporteService->getEstadisticasActividades($rango);
        $logros = $this->reporteService->getTotalLogros($rango);

        // Datos que sí dependen de la sala
        $consultasPorSala = $this->reporteService->getConsultasPorSala($rango); // array para todas las salas
        $demografia = $this->reporteService->getDistribucionDemografica($rango, $salaId);
        $consultasPorArea = $this->reporteService->getConsultasPorArea($rango, $salaId);
        $prestamosPorArea = $this->reporteService->getPrestamosPorArea($rango, $salaId);
        $totalEjemplaresPrestados = $this->reporteService->getTotalEjemplaresPrestados($rango, $salaId);

        // Para la tabla de préstamos por sala (solo en vista general), usamos getConsultasPorSala (ya lo tenemos)
        $prestamosPorSala = []; // si se necesita, podrías implementar getPrestamosPorSala

        // Pasar todos los datos a la vista
        return $this->render('report/report-operation', [
            'periodo' => $periodo,
            'sala' => $sala,
            'totales' => $totales,
            'consultasPorSala' => $consultasPorSala,
            'demografia' => $demografia,
            'consultasPorArea' => $consultasPorArea,
            'prestamosPorArea' => $prestamosPorArea,
            'totalEjemplaresPrestados' => $totalEjemplaresPrestados,
            'actividades' => $actividades,
            'logros' => $logros,
        ]);
    }

    // Endpoint para AJAX: Devuelve datos filtrados en formato JSON

    public function ajaxDatos(): void
    {
        header('Content-Type: application/json');
        
        $periodo = $_GET['periodo'] ?? 'mes';
        $sala = $_GET['sala'] ?? 'general';
        
        // Calcular rango de fechas
        $rango = $this->reporteService->calcularRango($periodo);
        
        // Mapear sala a ID (null para general)
        $salaId = $this->mapearSalaId($sala);
        
        // Obtener datos según filtros
        $totales = $this->reporteService->getTotalesPeriodo($rango);
        $consultasPorSala = $this->reporteService->getConsultasPorSala($rango);
        $demografia = $this->reporteService->getDistribucionDemografica($rango, $salaId);
        $consultasPorArea = $this->reporteService->getConsultasPorArea($rango, $salaId);
        $prestamosPorArea = $this->reporteService->getPrestamosPorArea($rango, $salaId);
        $totalEjemplaresPrestados = $this->reporteService->getTotalEjemplaresPrestados($rango, $salaId);
        
        // Actividades y logros SOLO para reporte general (cuando $salaId === null)
        if ($salaId === null) {
            $actividades = $this->reporteService->getEstadisticasActividades($rango);
            $logros = $this->reporteService->getTotalLogros($rango);
        } else {
            $actividades = null;
            $logros = null;
        }
        
        echo json_encode([
            'success' => true,
            'totales' => $totales,
            'consultasPorSala' => $consultasPorSala,
            'demografia' => $demografia,
            'consultasPorArea' => $consultasPorArea,
            'prestamosPorArea' => $prestamosPorArea,
            'totalEjemplaresPrestados' => $totalEjemplaresPrestados,
            'actividades' => $actividades,
            'logros' => $logros,
            'sala' => $sala,
            'periodo' => $periodo
        ]);
    }

    /**
     * Convierte el nombre de la pestaña al ID_Sala correspondiente en la base de datos.
     * @param string $sala
     * @return string|null null para todas las salas (reporte general)
     */
    private function mapearSalaId(string $sala): ?string
    {
        return match ($sala) {
            'sala_general' => 'G',
            'sala_referencia' => 'R',
            'sala_estatal' => 'SE',
            'sala_infantil' => 'X',
            default => null, // 'general' o cualquier otro valor -> null (todas las salas)
        };
    }
}