<?php
namespace App\Models\Repositories;
use App\Core\baseRepository;
use App\Contracts\IPreguntaRepository;
use App\Models\Entities\pregunta;
use PDO;

class preguntaRepository extends baseRepository implements IPreguntaRepository{
    public function __construct (PDO $pdo) {
        parent::__construct($pdo, "preguntas_seguridad", "ID_Pregunta");
    }

    protected function mapToEntity(array $row): pregunta {
        return pregunta::fromArray($row);
    }

}