<?php
namespace App\Models\Services;

use App\Models\Repositories\PersonaRepository;
use App\Models\Repositories\LectorRepository;
use App\Models\Entities\Persona;
use App\Models\Entities\Lector;
use PDO;

class LectorRegistrationService {

    private PersonaRepository $personaRepo;
    private LectorRepository $lectorRepo;
    private PDO $pdo;

    public function __construct(
        PersonaRepository $personaRepo,
        LectorRepository $lectorRepo,
        PDO $pdo
    ) {
        $this->personaRepo = $personaRepo;
        $this->lectorRepo = $lectorRepo;
        $this->pdo = $pdo;
    }

    //Registra un lector vinculado a una persona.
    //Si la persona ya existe, se reutiliza su ID.
    public function registrar(Persona $persona, Lector $lector): int {
        try {
            $this->pdo->beginTransaction();

            // 1. Verificar si la persona ya existe (ej. por email)
            $personaExistente = $this->personaRepo->findByEmail($persona->getEmail());

            if ($personaExistente) {
                $idPersona = $personaExistente->getIdPersona();
            } else {
                // Insertar nueva persona
                $idPersona = $this->personaRepo->insert($persona);
            }

            // 2. Asignar el ID_Persona al lector
            $lector->setIdPersona($idPersona);

            // 3. Insertar lector
            $idLector = $this->lectorRepo->insert($lector);

            $this->pdo->commit();
            return $idLector;

        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}