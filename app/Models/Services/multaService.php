<?php

namespace App\Models\Services;

use App\Contracts\IMultaRepository;

class MultaService
{
    private IMultaRepository $multaRepo;

    public function __construct(IMultaRepository $multaRepo)
    {
        $this->multaRepo = $multaRepo;
    }

    /**
     * Marca una multa como pagada.
     *
     * @param int $idMulta
     * @param int $idAdmin   (OPCIONAL: podría guardarse en historial, aquí no se persiste salvo en la multa)
     * @return array ['success' => bool, 'message' => string]
     */
    public function pagarMulta(int $idMulta, int $idAdmin): array
    {
        $multa = $this->multaRepo->find($idMulta);
        if (!$multa) {
            return ['success' => false, 'message' => 'La multa no existe.'];
        }
        if ($multa->getEstado() !== 'Pendiente') {
            return ['success' => false, 'message' => 'Solo se pueden pagar multas en estado Pendiente.'];
        }

        $fechaHoy = date('Y-m-d');
        $resultado = $this->multaRepo->marcarPagada($idMulta, $fechaHoy);
        if ($resultado) {
            // Opcional: registrar en historial quién pagó. Por ahora solo actualizamos.
            return ['success' => true, 'message' => 'Multa pagada correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar la multa.'];
        }
    }

    /**
     * Marca una multa como cancelada (por ejemplo, si se determinó que no correspondía).
     *
     * @param int $idMulta
     * @param int $idAdmin
     * @return array
     */
    public function cancelarMulta(int $idMulta, int $idAdmin): array
    {
        $multa = $this->multaRepo->find($idMulta);
        if (!$multa) {
            return ['success' => false, 'message' => 'La multa no existe.'];
        }
        if ($multa->getEstado() !== 'Pendiente') {
            return ['success' => false, 'message' => 'Solo se pueden cancelar multas en estado Pendiente.'];
        }

        $resultado = $this->multaRepo->marcarCancelada($idMulta);
        if ($resultado) {
            // Opcional: registrar fecha de cancelación (ya lo hace el repositorio con fecha actual)
            return ['success' => true, 'message' => 'Multa cancelada.'];
        } else {
            return ['success' => false, 'message' => 'Error al cancelar la multa.'];
        }
    }
}