<?php

namespace App\Models\Services;

use App\Contracts\IPrestamoRepository;
use App\Contracts\IEjemplarPrestamoRepository;
use App\Contracts\ILectorRepository;
use App\Contracts\IEjemplarRepository;
use App\Contracts\IConfiguracionRepository;
use App\Contracts\IMultaRepository;
use App\Contracts\ILibroRepository;
use App\Models\Entities\Prestamo;
use App\Models\Services\FechaService;
use PDO;

class PrestamoRegistrationService
{
    private PDO $pdo;
    private IPrestamoRepository $prestamoRepo;
    private IEjemplarPrestamoRepository $ejemplarPrestamoRepo;
    private ILectorRepository $lectorRepo;
    private IEjemplarRepository $ejemplarRepo;
    private IConfiguracionRepository $configRepo;
    private IMultaRepository $multaRepo;
    private ILibroRepository $libroRepo;
    private FechaService $fechaService;

    public function __construct(
        IPrestamoRepository $prestamoRepo,
        IEjemplarPrestamoRepository $ejemplarPrestamoRepo,
        ILectorRepository $lectorRepo,
        IEjemplarRepository $ejemplarRepo,
        IConfiguracionRepository $configRepo,
        IMultaRepository $multaRepo,
        ILibroRepository $libroRepo,
        FechaService $fechaService,
        PDO $pdo,
    ) {
        $this->prestamoRepo = $prestamoRepo;
        $this->ejemplarPrestamoRepo = $ejemplarPrestamoRepo;
        $this->lectorRepo = $lectorRepo;
        $this->ejemplarRepo = $ejemplarRepo;
        $this->configRepo = $configRepo;
        $this->multaRepo = $multaRepo;
        $this->libroRepo = $libroRepo;
        $this->fechaService = $fechaService;
        $this->pdo = $pdo;
    }


    /**
     * Registra un nuevo préstamo.
     *
     * @param int $idLector
     * @param array $idsEjemplares
     * @param int $idAdmin
     * @return Prestamo
     * @throws \Exception Si alguna validación falla o hay error en BD.
     */
    public function registrar(int $idLector, array $idsEjemplares, int $idAdmin): Prestamo
    {
        $ejemplares = [];
        $configuracion = $this->configRepo->getConfiguracion();
        if (!$configuracion) {
            throw new \Exception("No se pudo obtener la configuración del sistema.");
        }
        // 1. Validar lector
        $lector = $this->lectorRepo->find($idLector);
        if (!$lector) {
            throw new \Exception("El lector no existe.");
        }
        if ($lector->getEstado() !== 'Activo') {
            throw new \Exception("El lector no está activo.");
        }

        // 2. Verificar multas pendientes
        $multasPendientes = $this->multaRepo->findPendientesByLector($idLector);
        if (!empty($multasPendientes)) {
            throw new \Exception("El lector tiene multas pendientes. No puede realizar nuevos préstamos.");
        }

        // 3. Verificar límite de préstamos activos
        $prestamosActivos = $this->prestamoRepo->findPrestamosActivosByLector($idLector);
        $limite = (int) $configuracion->getLimitePrestamosSimultaneos();
        if (count($prestamosActivos) >= $limite) {
            throw new \Exception("El lector ha alcanzado el límite de préstamos simultáneos ({$limite}).");
        }

        // Validar cada ejemplar: debe existir, estar disponible y no estar ya en otro préstamo activo
        foreach ($idsEjemplares as $idEjemplar) {
            $ejemplar = $this->ejemplarRepo->find($idEjemplar);
            if (!$ejemplar || $ejemplar->getEstado() !== 'Disponible') {
                throw new \Exception("El ejemplar ID $idEjemplar no está disponible.");
            }
            // Verificar que no esté ya en un préstamo activo (por si acaso)
            $prestamoExistente = $this->prestamoRepo->findPrestamosActivosByEjemplar($idEjemplar);
            if ($prestamoExistente) {
                throw new \Exception("El ejemplar ID $idEjemplar ya está prestado actualmente.");
            }
            $ejemplares[] = $ejemplar;
        }

        foreach ($ejemplares as $ejemplar) {
            $libro = $this->libroRepo->find($ejemplar->getLibroId());
            if (!$libro || !$libro->isActivo()) {
                throw new \Exception("El libro asociado al ejemplar ID {$ejemplar->getIdEjemplar()} no está activo.");
            }
            if ($libro->getIdArea() === 'N' || $libro->getIdArea() === 'NV') {
                $novelas = true;
            }
        }

        // 6. Calcular fechas

        $fechaActual = date('Y-m-d');        
        
        if (isset($novelas) && $novelas) {
            $diasPrestamo = (int) $configuracion->getDiasPrestamoNovelas();
        } else {
            $diasPrestamo = (int) $configuracion->getDiasPrestamo();
        }
        $fechaEstipulada = $this->fechaService->sumarDiasHabiles($fechaActual, $diasPrestamo);

        $prestamo = new Prestamo(
            null,               
            $idLector,
            $idAdmin,
            $fechaActual,
            $fechaEstipulada,
            null,               // fechaRecepcionReal
            'Pendiente',
            true                // activo
        );

        // 8. Transacción para guardar todo
        $this->pdo->beginTransaction();
        try {
            foreach ($ejemplares as $ejemplar) {
                if (!$ejemplar) {
                    throw new \Exception("El ejemplar no existe.");
                }
                if (!$ejemplar->isActivo()) {
                    throw new \Exception("El ejemplar no está activo.");
                }
            }
            $idPrestamo = $this->prestamoRepo->insert($prestamo);
            foreach ($ejemplares as $ejemplar) {
                $this->ejemplarPrestamoRepo->associate($idPrestamo, $ejemplar->getIdEjemplar());
            }
            foreach ($ejemplares as $ejemplar) {
                $ejemplar->setEstado('Prestado');
                $this->ejemplarRepo->updateEstado($ejemplar);
            }
            $this->pdo->commit();

            return $this->prestamoRepo->find($idPrestamo);
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw new \RuntimeException("Error al registrar el préstamo: " . $e->getMessage(), 0, $e);
        }
    }
}