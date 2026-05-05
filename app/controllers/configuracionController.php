<?php 
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\Entities\Configuracion;
use App\Models\Entities\Prestamo;
use App\Contracts\IConfiguracionRepository;
class ConfiguracionController extends BaseController {
    private IConfiguracionRepository $configuracionRepo;

    public function __construct(IConfiguracionRepository $configuracionRepo) {
        $this->authenticate();
        $this->configuracionRepo = $configuracionRepo;
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
        return $this->render('hall/hall');
    }

    public function areaConfiguration(): string {
        return $this->render('category/category');
    }

    public function historial(): string {
        return $this->render('history/history');
    }
    public function indicatorConfiguration(){
        return $this->render('indicator/indicator-configuration');
    }
}