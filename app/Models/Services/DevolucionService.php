<?php

namespace App\Models\Services;

use App\Contracts\IPrestamoRepository;
use App\Contracts\IEjemplarRepository;
use App\Contracts\IEjemplarPrestamoRepository;
use App\Contracts\IMultaRepository;
use App\Contracts\IConfiguracionRepository;
use App\Models\Entities\Multa;
use PDO;

class DevolucionService
{
    private PDO $pdo;
    private IPrestamoRepository $prestamoRepo;
    private IEjemplarRepository $ejemplarRepo;
    private IEjemplarPrestamoRepository $ejemplarPrestamoRepo;
    private IMultaRepository $multaRepo;
    private IConfiguracionRepository $configRepo;

    public function __construct(
        PDO $pdo,
        IPrestamoRepository $prestamoRepo,
        IEjemplarRepository $ejemplarRepo,
        IEjemplarPrestamoRepository $ejemplarPrestamoRepo,
        IMultaRepository $multaRepo,
        IConfiguracionRepository $configRepo
    ) {
        $this->pdo = $pdo;
        $this->prestamoRepo = $prestamoRepo;
        $this->ejemplarRepo = $ejemplarRepo;
        $this->ejemplarPrestamoRepo = $ejemplarPrestamoRepo;
        $this->multaRepo = $multaRepo;
        $this->configRepo = $configRepo;
    }

    /**
     * Previsualiza una devolución: calcula posible multa y obtiene ejemplares.
     * 
     * @param int $idPrestamo
     * @return array ['success'=>bool, 'multaInfo'=>array|null, 'ejemplares'=>array, 'message'=>string]
     */
    public function previsualizar(int $idPrestamo): array
    {
        $prestamo = $this->prestamoRepo->find($idPrestamo);
        if (!$prestamo || $prestamo->getEstadoEntrega() !== 'Pendiente') {
            return ['success' => false, 'message' => 'Préstamo no válido o ya devuelto.'];
        }

        // Obtener ejemplares del préstamo
        $idsEjemplares = $this->ejemplarPrestamoRepo->findByPrestamo($idPrestamo);
        $ejemplares = [];
        foreach ($idsEjemplares as $idEj) {
            $ej = $this->ejemplarRepo->find($idEj);
            if ($ej) $ejemplares[] = $ej;
        }

        // Calcular posible multa por retraso (sin generarla aún)
        $config = $this->configRepo->getConfiguracion();
        $diasRetraso = $this->calcularDiasRetraso($prestamo->getFechaRecepcionEstipulada());
        $multaInfo = null;
        if ($diasRetraso > 0) {
            $monto = $diasRetraso * $config->getMultaDiaria();
            $multaInfo = [
                'diasRetraso' => $diasRetraso,
                'monto' => $monto,
                'moneda' => 'USD'
            ];
        }

        return [
            'success' => true,
            'multaInfo' => $multaInfo,
            'ejemplares' => $ejemplares,
            'prestamo' => $prestamo
        ];
    }

    /**
     * Ejecuta la devolución completa, asignando estado a cada ejemplar y generando multa si aplica.
     *
     * @param int   $idPrestamo
     * @param int   $idAdmin
     * @param array $estadosEjemplares  [ idEjemplar => 'Disponible' | 'Dañado' ]
     * @return array ['success'=>bool, 'message'=>string, 'multa'=>Multa|null]
     */
    public function devolverPrestamoCompleto(int $idPrestamo, int $idAdmin, array $estadosEjemplares): array
    {
        $this->pdo->beginTransaction();

        try {
            $prestamo = $this->prestamoRepo->find($idPrestamo);
            if (!$prestamo || $prestamo->getEstadoEntrega() !== 'Pendiente') {
                throw new \Exception("Préstamo no válido o ya devuelto.");
            }

            // Obtener ejemplares reales del préstamo
            $idsEjemplaresBD = $this->ejemplarPrestamoRepo->findByPrestamo($idPrestamo);
            if (empty($idsEjemplaresBD)) {
                throw new \Exception("El préstamo no tiene ejemplares asociados.");
            }

            // Verificar que recibimos estado para cada ejemplar
            foreach ($idsEjemplaresBD as $idEj) {
                if (!isset($estadosEjemplares[$idEj])) {
                    throw new \Exception("Falta el estado para el ejemplar ID $idEj.");
                }
                $estado = $estadosEjemplares[$idEj];
                if (!in_array($estado, ['Disponible', 'Dañado'])) {
                    throw new \Exception("Estado no válido para ejemplar ID $idEj.");
                }
            }

            // Calcular multa por retraso (si aplica)
            $config = $this->configRepo->getConfiguracion();
            $diasRetraso = $this->calcularDiasRetraso($prestamo->getFechaRecepcionEstipulada());
            $multa = null;
            if ($diasRetraso > 0) {
                $monto = $diasRetraso * $config->getMultaDiaria();
                $multa = $this->crearMulta($idPrestamo, $idAdmin, $monto);
            }

            // Actualizar cada ejemplar con el estado indicado
            foreach ($idsEjemplaresBD as $idEj) {
                $ejemplar = $this->ejemplarRepo->find($idEj);
                if (!$ejemplar) {
                    throw new \Exception("Ejemplar ID $idEj no encontrado.");
                }
                $ejemplar->setEstado($estadosEjemplares[$idEj]);
                $this->ejemplarRepo->updateEstado($ejemplar);
                // Registro de daños (pendiente)
            }

            // Registrar devolución
            $fechaReal = date('Y-m-d');
            $estadoEntrega = $diasRetraso > 0 ? 'Vencido' : 'Devuelto';
            $this->prestamoRepo->registrarDevolucion($idPrestamo, $fechaReal, $estadoEntrega);

            $this->pdo->commit();

            $message = $multa ? "Devolución registrada. Se generó multa de {$multa->getMonto()} USD." : "Devolución registrada sin multa.";
            return ['success' => true, 'message' => $message, 'multa' => $multa];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'multa' => null];
        }
    }

    private function calcularDiasRetraso(string $fechaEstipulada): int
    {
        $hoy = new \DateTime();
        $est = new \DateTime($fechaEstipulada);
        if ($hoy > $est) {
            return $hoy->diff($est)->days;
        }
        return 0;
    }

    private function crearMulta(int $idPrestamo, int $idAdmin, float $monto): Multa
    {
        $multa = new Multa(null, $idPrestamo, $idAdmin, $monto, null, 'Pendiente');
        $id = $this->multaRepo->insert($multa);
        $multa->setIdMulta($id);
        return $multa;
    }
}