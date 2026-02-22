<?php

namespace App\Models\Services;

use App\Contracts\IVisitanteRepository;
use App\Contracts\IConsultaRepository;
use App\Models\Entities\VisitantesRegistro;
use App\Models\Entities\ConsultaRegistro;
use PDO;

class VisitanteService {

    private IVisitanteRepository $visitanteRepo;
    private IConsultaRepository $consultaRepo;
    private PDO $pdo;

    public function __construct(
        IVisitanteRepository $visitanteRepo,
        IConsultaRepository $consultaRepo,
        PDO $pdo
    ) {
        $this->visitanteRepo = $visitanteRepo;
        $this->consultaRepo = $consultaRepo;
        $this->pdo = $pdo;
    }

    /**
     * Registra visitantes y consultas en una sola transacción.
     *
     * @param VisitantesRegistro $visitante
     * @param ConsultaRegistro[] $consultas
     * @return int ID del registro de visitantes creado
     * @throws \Exception
     */
    public function registrar(VisitantesRegistro $visitante, array $consultas): int {
        try {
            $this->pdo->beginTransaction();

            // Validar unicidad de visitante
            if ($this->visitanteRepo->existsBySalaFechaTurno(
                $visitante->getIdSala(),
                $visitante->getFecha(),
                $visitante->getTurno()
            )) {
                throw new \RuntimeException("Ya existe un registro de visitantes para esta sala, fecha y turno.");
            }

            $idConteo = $this->visitanteRepo->insert($visitante);
            $visitante->setIdConteo($idConteo);

            // Validar e insertar consultas
            foreach ($consultas as $consulta) {
                if ($this->consultaRepo->existsBySalaFechaTurnoArea(
                    $consulta->getIdSala(),
                    $consulta->getFecha(),
                    $visitante->getTurno(),   // usamos el mismo turno del visitante
                    $consulta->getIdArea()
                )) {
                    throw new \RuntimeException(
                        "Ya existe una consulta para el área {$consulta->getIdArea()} en esta sala, fecha y turno."
                    );
                }
                $consulta->setTurno($visitante->getTurno()); // aseguramos consistencia
                $this->consultaRepo->insert($consulta);
            }


            $this->pdo->commit();
            return $idConteo;

        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

}
