<?php
namespace App\Models\Entities;

use App\Core\baseEntity;

class ConfiguracionDashboard extends baseEntity
{
    private ?int $id;
    private bool $mostrarCobertura;
    private bool $mostrarReferencia;
    private bool $mostrarGraficoConsultas;
    private bool $mostrarCumplimiento;
    private bool $mostrarOcupacion;
    private bool $mostrarRotacion;
    private bool $mostrarEstadoFisico;
    private bool $mostrarAsistenciaEstatal;
    private bool $mostrarColeccion;
    private bool $mostrarActividades;
    private bool $mostrarIiur;
    private bool $mostrarIdcar;
    private bool $mostrarIpe;

    public function __construct(
        ?int $id = null,
        bool $mostrarCobertura = true,
        bool $mostrarReferencia = true,
        bool $mostrarGraficoConsultas = true,
        bool $mostrarCumplimiento = true,
        bool $mostrarOcupacion = true,
        bool $mostrarRotacion = true,
        bool $mostrarEstadoFisico = true,
        bool $mostrarAsistenciaEstatal = true,
        bool $mostrarColeccion = true,
        bool $mostrarActividades = true,
        bool $mostrarIiur = true,
        bool $mostrarIdcar = true,
        bool $mostrarIpe = true
    ) {
        $this->id = $id;
        $this->mostrarCobertura = $mostrarCobertura;
        $this->mostrarReferencia = $mostrarReferencia;
        $this->mostrarGraficoConsultas = $mostrarGraficoConsultas;
        $this->mostrarCumplimiento = $mostrarCumplimiento;
        $this->mostrarOcupacion = $mostrarOcupacion;
        $this->mostrarRotacion = $mostrarRotacion;
        $this->mostrarEstadoFisico = $mostrarEstadoFisico;
        $this->mostrarAsistenciaEstatal = $mostrarAsistenciaEstatal;
        $this->mostrarColeccion = $mostrarColeccion;
        $this->mostrarActividades = $mostrarActividades;
        $this->mostrarIiur = $mostrarIiur;
        $this->mostrarIdcar = $mostrarIdcar;
        $this->mostrarIpe = $mostrarIpe;
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getMostrarCobertura(): bool { return $this->mostrarCobertura; }
    public function getMostrarReferencia(): bool { return $this->mostrarReferencia; }
    public function getMostrarGraficoConsultas(): bool { return $this->mostrarGraficoConsultas; }
    public function getMostrarCumplimiento(): bool { return $this->mostrarCumplimiento; }
    public function getMostrarOcupacion(): bool { return $this->mostrarOcupacion; }
    public function getMostrarRotacion(): bool { return $this->mostrarRotacion; }
    public function getMostrarEstadoFisico(): bool { return $this->mostrarEstadoFisico; }
    public function getMostrarAsistenciaEstatal(): bool { return $this->mostrarAsistenciaEstatal; }
    public function getMostrarColeccion(): bool { return $this->mostrarColeccion; }
    public function getMostrarActividades(): bool { return $this->mostrarActividades; }
    public function getMostrarIiur(): bool { return $this->mostrarIiur; }
    public function getMostrarIdcar(): bool { return $this->mostrarIdcar; }
    public function getMostrarIpe(): bool { return $this->mostrarIpe; }

    // Setters
    public function setId(?int $id): void { $this->id = $id; }
    public function setMostrarCobertura(bool $value): void { $this->mostrarCobertura = $value; }
    public function setMostrarReferencia(bool $value): void { $this->mostrarReferencia = $value; }
    public function setMostrarGraficoConsultas(bool $value): void { $this->mostrarGraficoConsultas = $value; }
    public function setMostrarCumplimiento(bool $value): void { $this->mostrarCumplimiento = $value; }
    public function setMostrarOcupacion(bool $value): void { $this->mostrarOcupacion = $value; }
    public function setMostrarRotacion(bool $value): void { $this->mostrarRotacion = $value; }
    public function setMostrarEstadoFisico(bool $value): void { $this->mostrarEstadoFisico = $value; }
    public function setMostrarAsistenciaEstatal(bool $value): void { $this->mostrarAsistenciaEstatal = $value; }
    public function setMostrarColeccion(bool $value): void { $this->mostrarColeccion = $value; }
    public function setMostrarActividades(bool $value): void { $this->mostrarActividades = $value; }
    public function setMostrarIiur(bool $value): void { $this->mostrarIiur = $value; }
    public function setMostrarIdcar(bool $value): void { $this->mostrarIdcar = $value; }
    public function setMostrarIpe(bool $value): void { $this->mostrarIpe = $value; }
}