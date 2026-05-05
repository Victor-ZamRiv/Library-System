<?php
namespace App\Models\Services;

use App\Contracts\IPrestamoRepository;
use App\Contracts\IEjemplarPrestamoRepository;
use App\Contracts\IEjemplarRepository;
use App\Contracts\ILibroRepository;
use App\Contracts\IConfiguracionRepository;
use PDO;

class PrestamoRenovacionService
{
    private IPrestamoRepository $prestamoRepo;
    private IEjemplarPrestamoRepository $ejemplarPrestamoRepo;
    private IEjemplarRepository $ejemplarRepo;
    private ILibroRepository $libroRepo;
    private IConfiguracionRepository $configRepo;
    private FechaService $fechaService;
    private PDO $pdo;

    public function __construct(
        IPrestamoRepository $prestamoRepo,
        IEjemplarPrestamoRepository $ejemplarPrestamoRepo,
        IEjemplarRepository $ejemplarRepo,
        ILibroRepository $libroRepo,
        IConfiguracionRepository $configRepo,
        FechaService $fechaService,
        PDO $pdo
    ) {
        $this->prestamoRepo = $prestamoRepo;
        $this->ejemplarPrestamoRepo = $ejemplarPrestamoRepo;
        $this->ejemplarRepo = $ejemplarRepo;
        $this->libroRepo = $libroRepo;
        $this->configRepo = $configRepo;
        $this->fechaService = $fechaService;
        $this->pdo = $pdo;
    }

    public function renovar(int $idPrestamo, int $idAdmin): array
    {
        $prestamo = $this->prestamoRepo->find($idPrestamo);
        if (!$prestamo) {
            return ['success' => false, 'message' => 'Préstamo no encontrado'];
        }
        if ($prestamo->getEstadoEntrega() !== 'Pendiente') {
            return ['success' => false, 'message' => 'No se puede renovar un préstamo ya devuelto o vencido'];
        }

        $config = $this->configRepo->getConfiguracion();
        if (!$config) {
            return ['success' => false, 'message' => 'Error de configuración del sistema'];
        }

        $limite = $config->getMaxRenovaciones();
        if ($prestamo->getRenovaciones() >= $limite) {
            return ['success' => false, 'message' => "Límite de renovaciones alcanzado (máximo {$limite})"];
        }

        // Obtener los ejemplares asociados al préstamo
        $idsEjemplares = $this->ejemplarPrestamoRepo->findByPrestamo($idPrestamo);
        if (empty($idsEjemplares)) {
            return ['success' => false, 'message' => 'El préstamo no tiene ejemplares asociados'];
        }

        // Determinar si es novela: tomamos el primer ejemplar (puedes modificar la lógica si hay mezcla)
        $primerEjemplar = $this->ejemplarRepo->find($idsEjemplares[0]);
        if (!$primerEjemplar) {
            return ['success' => false, 'message' => 'Ejemplar no encontrado'];
        }

        $libro = $this->libroRepo->find($primerEjemplar->getLibroId());
        if (!$libro) {
            return ['success' => false, 'message' => 'Libro no encontrado'];
        }

        // Decidir los días a sumar según el área
        if ($libro->getIdArea() === 'N') { // Novela
            $diasSumar = $config->getDiasPrestamoNovelas();
        } else {
            $diasSumar = $config->getDiasPrestamo();
        }

        $fechaActualEstipulada = $prestamo->getFechaRecepcionEstipulada();
        $nuevaFecha = $this->fechaService->sumarDiasHabiles($fechaActualEstipulada, $diasSumar);

        $this->pdo->beginTransaction();
        try {
            $prestamo->setFechaRecepcionEstipulada($nuevaFecha);
            $prestamo->setRenovaciones($prestamo->getRenovaciones() + 1);
            $this->prestamoRepo->update($prestamo);
            $this->pdo->commit();

            return [
                'success' => true,
                'message' => 'Préstamo renovado exitosamente',
                'nuevaFecha' => $nuevaFecha
            ];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return [
                'success' => false,
                'message' => 'Error al renovar: ' . $e->getMessage()
            ];
        }
    }
}