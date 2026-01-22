<?php
namespace App\Models\Services;

use App\Contracts\ILectorRepository;
use App\Contracts\IPersonaRepository;
use App\Models\Entities\Lector;
class ListLectorService {

    private ILectorRepository $lectorRepo;
    private IPersonaRepository $personaRepo;

    public function __construct(
        ILectorRepository $lectorRepo,
        IPersonaRepository $personaRepo
    ) {
        $this->lectorRepo = $lectorRepo;
        $this->personaRepo = $personaRepo;
    }

    /**
     * Devuelve todos los lectores con su información personal asociada
     * @return Lector[]
     */
    public function listar(): array {
        $lectores = $this->lectorRepo->all(); 

        foreach ($lectores as $lector) {
            $persona = $this->personaRepo->find($lector->getIdPersona());
            if ($persona) {
                $lector->setPersona($persona);
            }
        }

        return $lectores;
    }
}