<?php

namespace App\Models\Entities;
use App\Core\baseEntity;

class pregunta extends baseEntity {
    protected ?int $idPregunta;
    protected string $pregunta;

    public function __construct (?int $idPregunta = null, string $pregunta = "") {
        $this->idPregunta = $this->setIdPregunta($idPregunta);
        $this->pregunta = $pregunta;
    }

    //getters
    public function getIdPregunta(): ?int {return $this->idPregunta; }
    public function getPregunta(): string {return $this->pregunta; }

    public function setIdPregunta($idPregunta): void {$this->idPregunta = (int)$idPregunta;}
    public function setPregunta($pregunta): void {$this->pregunta = $pregunta;}

}