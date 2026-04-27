<?php

namespace App\Models\Services;

use App\Contracts\IPrestamoRepository;
use App\Contracts\IEjemplarPrestamoRepository;
use App\Contracts\ILectorRepository;
use App\Contracts\IEjemplarRepository;
use App\Contracts\IConfiguracionRepository;
use App\Contracts\IMultaRepository;
use App\Models\Entities\Prestamo;
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

    public function __construct(
        PDO $pdo,
        IPrestamoRepository $prestamoRepo,
        IEjemplarPrestamoRepository $ejemplarPrestamoRepo,
        ILectorRepository $lectorRepo,
        IEjemplarRepository $ejemplarRepo,
        IConfiguracionRepository $configRepo,
        IMultaRepository $multaRepo
    ) {
        $this->pdo = $pdo;
        $this->prestamoRepo = $prestamoRepo;
        $this->ejemplarPrestamoRepo = $ejemplarPrestamoRepo;
        $this->lectorRepo = $lectorRepo;
        $this->ejemplarRepo = $ejemplarRepo;
        $this->configRepo = $configRepo;
        $this->multaRepo = $multaRepo;
    }

    /**
     * Registra un nuevo préstamo.
     *
     * @param int $idLector
     * @param int $idEjemplar
     * @param int $idAdmin
     * @return Prestamo
     * @throws \Exception Si alguna validación falla o hay error en BD.
     */
    public function registrar(int $idLector, int $idEjemplar, int $idAdmin): Prestamo
    {
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
        $limite = (int) $configuracion->getMaximoPrestamos();
        if (count($prestamosActivos) >= $limite) {
            throw new \Exception("El lector ha alcanzado el límite de préstamos simultáneos ({$limite}).");
        }

        // 4. Validar ejemplar
        $ejemplar = $this->ejemplarRepo->find($idEjemplar);
        if (!$ejemplar) {
            throw new \Exception("El ejemplar no existe.");
        }
        if (!$ejemplar->isActivo()) {
            throw new \Exception("El ejemplar no está activo.");
        }
        if ($ejemplar->getEstado() !== 'Disponible') {
            throw new \Exception("El ejemplar no está disponible para préstamo.");
        }

        // 5. Verificar que el ejemplar no esté ya en un préstamo activo (doble chequeo)
        $prestamoExistente = $this->ejemplarPrestamoRepo->findByEjemplar($idEjemplar);
        if ($prestamoExistente !== null) {
            throw new \Exception("El ejemplar ya se encuentra prestado actualmente.");
        }

        // 6. Calcular fechas
        $fechaActual = date('Y-m-d');
        $diasPrestamo = (int) $configuracion->getDiasPrestamo();
        $fechaEstipulada = date('Y-m-d', strtotime("+{$diasPrestamo} days"));

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
            $ejemplar = $this->ejemplarRepo->find($idEjemplar);
            if (!$ejemplar) {
                throw new \Exception("El ejemplar no existe.");
            }
             if (!$ejemplar->isActivo()) {
                throw new \Exception("El ejemplar no está activo.");
            }
            $idPrestamo = $this->prestamoRepo->insert($prestamo);
            $this->ejemplarPrestamoRepo->associate($idPrestamo, $idEjemplar);
            $this->ejemplarRepo->updateEstado($ejemplar, 'Prestado');
            $this->pdo->commit();

            return $this->prestamoRepo->find($idPrestamo);
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw new \RuntimeException("Error al registrar el préstamo: " . $e->getMessage(), 0, $e);
        }
    }
}