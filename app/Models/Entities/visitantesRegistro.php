<?php

namespace App\Models\Entities;

use App\Core\baseEntity;

class VisitantesRegistro extends baseEntity {

    private ?int $idConteo;
    private string $idSala;
    private string $fecha;
    private int $ninosHombres;
    private int $ninosMujeres;
    private int $adolescentesHombres;
    private int $adolescentesMujeres;
    private int $adultosHombres;
    private int $adultosMujeres;
    private string $turno;
    private ?int $idAdmin;

    public function __construct(
        ?int $idConteo = null,
        string $idSala = '',
        string $fecha = '',
        int $ninosHombres = 0,
        int $ninosMujeres = 0,
        int $adolescentesHombres = 0,
        int $adolescentesMujeres = 0,
        int $adultosHombres = 0,
        int $adultosMujeres = 0,
        string $turno = '',
        ?int $idAdmin = null
    ) {
        $this->idConteo = $idConteo;
        $this->idSala = $idSala;
        $this->fecha = $fecha;
        $this->turno = $turno;
        $this->ninosHombres = $ninosHombres;
        $this->ninosMujeres = $ninosMujeres;
        $this->adolescentesHombres = $adolescentesHombres;
        $this->adolescentesMujeres = $adolescentesMujeres;
        $this->adultosHombres = $adultosHombres;
        $this->adultosMujeres = $adultosMujeres;
        $this->idAdmin = $idAdmin;
    }

    // Getters
    public function getIdConteo(): ?int { return $this->idConteo; }
    public function getIdSala(): string { return $this->idSala; }
    public function getFecha(): string { return $this->fecha; }
    public function getNinosHombres(): int { return $this->ninosHombres; }
    public function getNinosMujeres(): int { return $this->ninosMujeres; }
    public function getAdolescentesHombres(): int { return $this->adolescentesHombres; }
    public function getAdolescentesMujeres(): int { return $this->adolescentesMujeres; }
    public function getAdultosHombres(): int { return $this->adultosHombres; }
    public function getAdultosMujeres(): int { return $this->adultosMujeres; }
    public function getTurno(): string { return $this->turno; }
    public function getIdAdmin(): ?int { return $this->idAdmin; }

    // Setters
    public function setIdConteo(?int $idConteo): void { $this->idConteo = $idConteo; }
    public function setIdSala(string $idSala): void { $this->idSala = $idSala; }
    public function setFecha(string $fecha): void { $this->fecha = $fecha; }
    public function setNinosHombres(int $n): void { $this->ninosHombres = $n; }
    public function setNinosMujeres(int $n): void { $this->ninosMujeres = $n; }
    public function setAdolescentesHombres(int $n): void { $this->adolescentesHombres = $n; }
    public function setAdolescentesMujeres(int $n): void { $this->adolescentesMujeres = $n; }
    public function setAdultosHombres(int $n): void { $this->adultosHombres = $n; }
    public function setAdultosMujeres(int $n): void { $this->adultosMujeres = $n; }
    public function setTurno(string $turno): void { $this->turno = $turno; }
    public function setIdAdmin(?int $idAdmin): void { $this->idAdmin = $idAdmin; }
}
