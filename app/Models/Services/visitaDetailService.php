<?php
namespace App\Models\Services;

use App\Contracts\IVisitanteRepository;
use App\Contracts\IConsultaRepository;

class VisitaDetailService
{
    private IVisitanteRepository $visitanteRepo;
    private IConsultaRepository $consultaRepo;

    public function __construct(IVisitanteRepository $visitanteRepo, IConsultaRepository $consultaRepo)
    {
        $this->visitanteRepo = $visitanteRepo;
        $this->consultaRepo = $consultaRepo;
    }

    public function obtenerDetalleCompleto(int $idConteo): ?array
    {
        $visitante = $this->visitanteRepo->find($idConteo);
        if (!$visitante) {
            return null;
        }
        $consultas = $this->consultaRepo->findBySalaFechaTurno(
            $visitante->getIdSala(),
            $visitante->getFecha(),
            $visitante->getTurno()
        );
        return [
            'visitante' => $visitante,
            'consultas' => $consultas
        ];
    }
}