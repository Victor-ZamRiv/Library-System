<?php
namespace App\Models\Services;

use App\Models\Repositories\VisitanteRepository;
use App\Models\Repositories\ConsultaRepository;
use App\Models\Entities\VisitantesRegistro;
use App\Models\Entities\ConsultaRegistro;
use PDO;

class VisitanteService
{
    private VisitanteRepository $visitanteRepo;
    private ConsultaRepository $consultaRepo;
    private PDO $pdo;

    public function __construct(VisitanteRepository $visitanteRepo, ConsultaRepository $consultaRepo, PDO $pdo)
    {
        $this->visitanteRepo = $visitanteRepo;
        $this->consultaRepo = $consultaRepo;
        $this->pdo = $pdo;
    }

    /**
     * @param array $data Datos del formulario
     * @param int $idAdmin
     * @return array ['success' => bool, 'message' => string]
     */
    public function registrar(array $data, int $idAdmin): array
    {
        // Validar fecha (hoy o hasta 3 días atrás)
        $fecha = $data['fecha'] ?? '';
        if (!$this->validarFecha($fecha)) {
            return ['success' => false, 'message' => 'La fecha debe ser hoy o máximo 3 días atrás.'];
        }

        // Validar sala y turno
        $sala = $data['sala'] ?? '';
        $turno = $data['turno'] ?? '';
        if (!in_array($sala, ['G', 'R', 'SE', 'X'])) {
            return ['success' => false, 'message' => 'Sala no válida.'];
        }
        if (!in_array($turno, ['Mañana', 'Tarde'])) {
            return ['success' => false, 'message' => 'Turno no válido.'];
        }

        // Construir entidad VisitantesRegistro
        $visitante = new VisitantesRegistro(
            null,
            $sala,
            $fecha,
            (int)($data['ninos_m'] ?? 0),
            (int)($data['ninos_f'] ?? 0),
            (int)($data['adol_m'] ?? 0),
            (int)($data['adol_f'] ?? 0),
            (int)($data['adultos_m'] ?? 0),
            (int)($data['adultos_f'] ?? 0),
            $turno,
            $idAdmin,
        );

        // Preparar consultas por área (obras)
        $areas = ['000', '100', '200', '300', '400', '500', '600', '700', '800', '900', 'N', 'NV', 'Biog'];
        $consultas = [];
        foreach ($areas as $area) {
            $cantidad = (int)($data['obra_' . $area] ?? 0);
            if ($cantidad > 0) {
                $consultas[] = new ConsultaRegistro(
                    null,
                    $sala,
                    $area,
                    $fecha,
                    $cantidad,
                    $turno,
                    $idAdmin,
                );
            }
        }

        // Transacción
        $this->pdo->beginTransaction();
        try {
            $this->visitanteRepo->insert($visitante);
            foreach ($consultas as $consulta) {
                if ($this->consultaRepo->existsBySalaFechaTurnoArea(
                    $consulta->getIdSala(),
                    $consulta->getFecha(),
                    $consulta->getTurno(),
                    $consulta->getIdArea()
                )) {
                    throw new \Exception("Ya existe un registro de consultas para el área {$consulta->getIdArea()} en esta sala, fecha y turno.");
                }
                $this->consultaRepo->insert($consulta);
            }
            $this->pdo->commit();
            return ['success' => true, 'message' => 'Registro guardado correctamente.'];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'message' => 'Error al guardar: ' . $e->getMessage()];
        }
    }

    private function validarFecha(string $fecha): bool
    {
        $timestamp = strtotime($fecha);
        if (!$timestamp) return false;
        $hoy = strtotime(date('Y-m-d'));
        $tresDiasAtras = strtotime('-3 days', $hoy);
        return ($timestamp >= $tresDiasAtras && $timestamp <= $hoy);
    }
}
