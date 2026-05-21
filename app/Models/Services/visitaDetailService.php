<?php
namespace App\Models\Services;

use App\Contracts\IVisitanteRepository;
use App\Contracts\IConsultaRepository;
use App\Contracts\IAdministradorRepository;
use App\Contracts\IPersonaRepository;

class VisitaDetailService
{
    private IVisitanteRepository $visitanteRepo;
    private IConsultaRepository $consultaRepo;
    private IAdministradorRepository $adminRepo;
    private IPersonaRepository $personaRepo;

    public function __construct(IVisitanteRepository $visitanteRepo, IConsultaRepository $consultaRepo, IAdministradorRepository $adminRepo, IPersonaRepository $personaRepo)
    {
        $this->visitanteRepo = $visitanteRepo;
        $this->consultaRepo = $consultaRepo;
        $this->adminRepo = $adminRepo;
        $this->personaRepo = $personaRepo;
    }

    public function obtenerDetalleCompleto(int $idConteo): ?array
    {
        $visitante = $this->visitanteRepo->find($idConteo);
        if (!$visitante) {
            return null;
        }
        $admin = $this->adminRepo->find($visitante->getIdAdmin());
        $persona = $this->personaRepo->find($admin->getIdPersona());
        if ($persona) {
            $admin->setPersona($persona);
        }
        $consultas = $this->consultaRepo->findBySalaFechaTurno(
            $visitante->getIdSala(),
            $visitante->getFecha(),
            $visitante->getTurno()
        );
        return [
            'visitante' => $visitante,
            'administrador' => $admin,
            'consultas' => $consultas
        ];
    }
}