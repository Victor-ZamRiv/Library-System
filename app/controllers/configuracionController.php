<?php 
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\Entities\Configuracion;
use App\Models\Entities\Prestamo;
use App\Contracts\IConfiguracionRepository;
use App\Contracts\ISalaRepository;
use App\Models\Services\DashboardConfigService;

class ConfiguracionController extends BaseController {
    private IConfiguracionRepository $configuracionRepo;
    private ISalaRepository $salaRepo;
    private DashboardConfigService $dashboardConfigService;

    public function __construct(IConfiguracionRepository $configuracionRepo, ISalaRepository $salaRepo, DashboardConfigService $dashboardConfigService) {
        $this->configuracionRepo = $configuracionRepo;
        $this->salaRepo = $salaRepo;
        $this->dashboardConfigService = $dashboardConfigService;
        $this->authenticate();
        $this->middlewareRol(['Director'], 'Configuración');
    }

    public function index(): string {
        return $this->render('configuracion/configuracion');
    }

    public function prestamoConfiguration(): string {
        $configuracion = $this->configuracionRepo->getConfiguracion();
            if (!$configuracion) {
                throw new \Exception('No se encontró la configuración actual.');
            }
        return $this->render('loan/config-loan', ['configuracion' => $configuracion]);
    }

    public function prestamoUpdate() {
        $diasPrestamo = $this->input('dias_prestamo');
        $multaDiaria = $this->input('monto_multa_dia');
        $diasPrestamoNovelas = $this->input('dias_prestamo_novelas');
        $maximoPrestamos = $this->input('maximo_prestamos');
        $limiteRenovaciones = $this->input('max_renovaciones');
        try {
            $configuracion = $this->configuracionRepo->getConfiguracion();
            if (!$configuracion) {
                throw new \Exception('No se encontró la configuración actual.');
            }
            $configuracion->setDiasPrestamo($diasPrestamo);
            $configuracion->setMontoMultaDia($multaDiaria);
            $configuracion->setDiasPrestamoNovelas($diasPrestamoNovelas);
            $configuracion->setLimitePrestamosSimultaneos($maximoPrestamos);
            $configuracion->setMaxRenovaciones($limiteRenovaciones);
            $this->configuracionRepo->updateConfiguracion($configuracion);
            $_SESSION['success'] = 'Configuración de préstamos actualizada exitosamente.';
            return $this->redirect('/configuracion/prestamos');
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error al actualizar la configuración: ' . $e->getMessage();
            return $this->redirect('/configuracion/prestamos');
        }

    }

    public function salaConfiguration(): string {
        $salas = [
            'G' => $this->salaRepo->find('G'),
            'R' => $this->salaRepo->find('R'),
            'E' => $this->salaRepo->find('SE'),
            'I' => $this->salaRepo->find('X')
        ];
        return $this->render('hall/hall', ['salas' => $salas]);
    }

    public function updateSalas(): void
        {
            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

            try {
                // Obtener datos del formulario
                $capacidadReferencia = (int) ($_POST['capacidad_referencia'] ?? 0);
                $capacidadEstatal    = (int) ($_POST['capacidad_estatal'] ?? 0);
                $capacidadInfantil   = (int) ($_POST['capacidad_infantil'] ?? 0);
                // Capacidad general (siempre activa, pero si se permite modificar)
                $capacidadGeneral    = (int) ($_POST['capacidad_general'] ?? 0);
                $salaReferenciaActiva = isset($_POST['sala_referencia']) ? 1 : 0;
                $salaEstatalActiva    = isset($_POST['sala_estatal']) ? 1 : 0;
                $salaInfantilActiva   = isset($_POST['sala_infantil']) ? 1 : 0;

                // Guardar en BD
                $this->salaRepo->updateCapacidad('G', $capacidadGeneral);
                $this->salaRepo->updateCapacidad('R', $capacidadReferencia);
                $this->salaRepo->updateCapacidad('SE', $capacidadEstatal);
                $this->salaRepo->updateCapacidad('X', $capacidadInfantil);

                $this->salaRepo->updateDisponible('R', $salaReferenciaActiva);
                $this->salaRepo->updateDisponible('SE', $salaEstatalActiva);
                $this->salaRepo->updateDisponible('X', $salaInfantilActiva);
                // Nota: Sala general ('G') no se modifica su disponibilidad (siempre 1)

                if ($isAjax) {
                    echo json_encode(['success' => true, 'message' => 'Configuración de salas actualizada.']);
                } else {
                    $_SESSION['success'] = 'Configuración de salas actualizada correctamente.';
                    $this->redirect('/configuracion/sala');
                }
            } catch (\Exception $e) {
                if ($isAjax) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                } else {
                    $_SESSION['error'] = 'Error al guardar: ' . $e->getMessage();
                    $this->redirect('/configuracion/sala');
                }
            }
        }

    public function areaConfiguration(): string {
        return $this->render('category/category');
    }

    public function historial(): string {
        return $this->render('history/history');
    }
    public function indicadores(): string
    {
        $config = $this->dashboardConfigService->getConfig();
        return $this->render('indicator/indicator-configuration', ['config' => $config]);
    }

    public function guardarIndicadores(): void
    {
        $this->dashboardConfigService->saveConfig($_POST);
        $_SESSION['success'] = 'Configuración guardada correctamente.';
        $this->redirect('/configuracion/indicator');
    }
}