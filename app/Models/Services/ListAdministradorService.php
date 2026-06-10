<?php 
namespace App\Models\Services;

use App\Contracts\IAdministradorRepository;
use App\Contracts\IPersonaRepository;
use App\Models\Entities\Administrador;

class ListAdministradorService {

    private IAdministradorRepository $adminRepo;
    private IPersonaRepository $personaRepo;

    public function __construct(
        IAdministradorRepository $adminRepo,
        IPersonaRepository $personaRepo
    ) {
        $this->adminRepo = $adminRepo;
        $this->personaRepo = $personaRepo;
    }

    /**
     * Devuelve todos los administradores con su información personal asociada
     * @return Administrador[]
     */
    public function listar(): array {
        $administradores = $this->adminRepo->all(); 

        foreach ($administradores as $admin) {
            $persona = $this->personaRepo->find($admin->getIdPersona());
            if ($persona) {
                $admin->setPersona($persona);
            }
        }

        return $administradores;
    }

    public function listarPaginado(int $pagina = 1, int $porPagina = 10, ?string $search = null): array
    {
        $resultado = $this->adminRepo->listarActivosPaginados($pagina, $porPagina, $search);
        foreach ($resultado['datos'] as $admin) {
            $admin->setPersona($this->personaRepo->find($admin->getIdPersona()));
        }
        return $resultado;
    }

    public function search(string $input): array {
        $administradores = $this->adminRepo->search($input);

        foreach ($administradores as $admin) {
            $persona = $this->personaRepo->find($admin->getIdPersona());
            if ($persona) {
                $admin->setPersona($persona);
            }
        }

        return $administradores;
    }
}