<?php
namespace App\Models\Services;

use App\Contracts\IPersonaRepository;
use App\Contracts\IAdministradorRepository;
use App\Models\Entities\Persona;
use App\Models\Entities\Administrador;
use PDO;

class AdministradorRegistrationService {

    private IPersonaRepository $personaRepo;
    private IAdministradorRepository $adminRepo;
    private PDO $pdo;

    public function __construct(
        IPersonaRepository $personaRepo,
        IAdministradorRepository $adminRepo,
        PDO $pdo
    ) {
        $this->personaRepo = $personaRepo;
        $this->adminRepo = $adminRepo;
        $this->pdo = $pdo;
    }

    // Registra un administrador vinculado a una persona.
    // Si la persona ya existe, se reutiliza su ID.
    public function registrar(Persona $persona, Administrador $admin): int {
        try {
            $this->pdo->beginTransaction();

            // 1. Verificar si la persona ya existe (ej. por email o nombre+apellido)
            $personaExistente = $this->personaRepo->findByCedula($persona->getCedula());

            if ($personaExistente) {
                $idPersona = $personaExistente->getIdPersona();                
            } else {
                // Insertar nueva persona
                $idPersona = $this->personaRepo->insert($persona);
            }

            if ($this->adminRepo->duplicatePersona($idPersona)) {
                throw new \Exception("La persona con cédula '{$persona->getCedula()}' ya está registrada como administrador.");
            }

            // 2. Asignar el ID_Persona al administrador
            $admin->setIdPersona($idPersona);

            // 3. Insertar administrador
            $idAdmin = $this->adminRepo->insert($admin);

            $this->pdo->commit();
            return $idAdmin;            

        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}