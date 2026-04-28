<?php

namespace App\Models\Services;

use App\Contracts\IPrestamoRepository;
use App\Contracts\IEjemplarPrestamoRepository;
use App\Contracts\IEjemplarRepository;
use App\Contracts\IMultaRepository;
use App\Contracts\IConfiguracionRepository;
use App\Models\Entities\Multa;
use PDO;

class DevolucionService
{
    private PDO $pdo;
    private IPrestamoRepository $prestamoRepo;
    private IEjemplarPrestamoRepository $ejemplarPrestamoRepo;
    private IEjemplarRepository $ejemplarRepo;
    private IMultaRepository $multaRepo;
    private IConfiguracionRepository $configRepo;

    public function __construct(
        PDO $pdo,
        IPrestamoRepository $prestamoRepo,
        IEjemplarPrestamoRepository $ejemplarPrestamoRepo,
        IEjemplarRepository $ejemplarRepo,
        IMultaRepository $multaRepo,
        IConfiguracionRepository $configRepo
    ) {
        $this->pdo = $pdo;
        $this->prestamoRepo = $prestamoRepo;
        $this->ejemplarPrestamoRepo = $ejemplarPrestamoRepo;
        $this->ejemplarRepo = $ejemplarRepo;
        $this->multaRepo = $multaRepo;
        $this->configRepo = $configRepo;
    }

    /**
     * Procesa la devolución completa de un préstamo.
     *
     * @param int  $idPrestamo
     * @param int  $idAdmin
     * @param bool $danado   Si algún ejemplar (o todos) está dañado.
     * @return array ['success' => bool, 'message' => string, 'multa' => ?Multa]
     */
    public function devolverPrestamoCompleto(int $idPrestamo, int $idAdmin, bool $danado = false): array
    {
        $this->pdo->beginTransaction();

        try {
            // 1. Obtener el préstamo
            $prestamo = $this->prestamoRepo->find($idPrestamo);
            if (!$prestamo) {
                throw new \Exception("Préstamo no encontrado.");
            }
            if ($prestamo->getEstadoEntrega() !== 'Pendiente') {
                throw new \Exception("Este préstamo ya fue devuelto o está vencido.");
            }

            // 2. Obtener todos los ejemplares asociados
            $idsEjemplares = $this->ejemplarPrestamoRepo->findByPrestamo($idPrestamo);
            if (empty($idsEjemplares)) {
                throw new \Exception("El préstamo no tiene ejemplares asociados.");
            }

            // 3. Calcular días de retraso
            $fechaReal = date('Y-m-d');
            $fechaEstipulada = $prestamo->getFechaRecepcionEstipulada();
            $diasRetraso = $this->calcularDiasRetraso($fechaEstipulada, $fechaReal);

            // 4. Generar multa si hay retraso
            $multa = null;
            if ($diasRetraso > 0) {
                $config = $this->configRepo->getConfiguracion();
                if (!$config) {
                    throw new \Exception("No se pudo obtener la configuración del sistema.");
                }
                $montoPorDia = $config->getMultaDiaria();
                $monto = $diasRetraso * $montoPorDia;
                $multa = $this->crearMulta($idPrestamo, $idAdmin, $monto);
            }

            // 5. Actualizar estado de cada ejemplar
            $nuevoEstadoEjemplar = $danado ? 'Dañado' : 'Disponible';
            foreach ($idsEjemplares as $idEjemplar) {
                $this->ejemplarRepo->updateEstado($idEjemplar, $nuevoEstadoEjemplar);
            }

            // 6. Registrar devolución en el préstamo
            $estadoEntrega = $diasRetraso > 0 ? 'Vencido' : 'Devuelto';
            $this->prestamoRepo->registrarDevolucion($idPrestamo, $fechaReal, $estadoEntrega);

            $this->pdo->commit();

            $message = $multa
                ? "Devolución completada. Se generó una multa de {$multa->getMonto()} USD."
                : "Devolución completada sin multa.";

            return ['success' => true, 'message' => $message, 'multa' => $multa];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'multa' => null];
        }
    }

    /**
     * Calcula los días de retraso (si la fecha real es posterior a la estipulada).
     */
    private function calcularDiasRetraso(string $fechaEstipulada, string $fechaReal): int
    {
        $est = new \DateTime($fechaEstipulada);
        $real = new \DateTime($fechaReal);
        if ($real > $est) {
            return $real->diff($est)->days;
        }
        return 0;
    }

    /**
     * Crea una nueva multa en la base de datos.
     */
    private function crearMulta(int $idPrestamo, int $idAdmin, float $monto): Multa
    {
        $multa = new Multa(null, $idPrestamo, $idAdmin, $monto, null, 'Pendiente');
        $id = $this->multaRepo->insert($multa);
        $multa->setIdMulta($id);
        return $multa;
    }
}