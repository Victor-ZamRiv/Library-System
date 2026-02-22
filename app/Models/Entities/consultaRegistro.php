<?php

namespace App\Models\Entities;

use App\Core\baseEntity;

class ConsultaRegistro extends baseEntity {

    private ?int $idConsultaArea;
    private string $idSala;
    private string $idArea;
    private string $fecha;
    private int $cantidadConsultada;
    private string $turno;
    private ?int $idAdmin;

    public function __construct(
        ?int $idConsultaArea = null,
        string $idSala = '',
        string $idArea = '',
        string $fecha = '',
        int $cantidadConsultada = 0,
        string $turno = '',
        ?int $idAdmin = null
    ) {
        $this->idConsultaArea = $idConsultaArea;
        $this->idSala = $idSala;
        $this->idArea = $idArea;
        $this->fecha = $fecha;
        $this->cantidadConsultada = $cantidadConsultada;
        $this->turno = $turno;
        $this->idAdmin = $idAdmin;
    }

    // Getters
    public function getIdConsultaArea(): ?int { return $this->idConsultaArea; }
    public function getIdSala(): string { return $this->idSala; }
    public function getIdArea(): string { return $this->idArea; }
    public function getFecha(): string { return $this->fecha; }
    public function getCantidadConsultada(): int { return $this->cantidadConsultada; }
    public function getTurno(): string { return $this->turno; }
    public function getIdAdmin(): ?int { return $this->idAdmin; }

    // Setters
    public function setIdConsultaArea(?int $id): void { $this->idConsultaArea = $id; }
    public function setIdSala(string $idSala): void { $this->idSala = $idSala; }
    public function setIdArea(string $idArea): void { $this->idArea = $idArea; }
    public function setFecha(string $fecha): void { $this->fecha = $fecha; }
    public function setCantidadConsultada(int $cantidad): void { $this->cantidadConsultada = $cantidad; }
    public function setTurno(string $turno): void { $this->turno = $turno; }
    public function setIdAdmin(?int $idAdmin): void { $this->idAdmin = $idAdmin; }
}
