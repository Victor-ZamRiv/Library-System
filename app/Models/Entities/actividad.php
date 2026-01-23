<?php
namespace App\Models\Entities;

use App\Core\baseEntity;

class Actividad extends baseEntity {
    private ?int $idActividad;
    private ?int $idAdmin;
    private string $organizador;
    private string $categoria;
    private string $estado;
    private ?int $asistentes;
    private string $descripcion;
    private string $fecha;

    public function __construct(
        ?int $idActividad = null,
        ?int $idAdmin = null,
        string $organizador = '',
        string $categoria = '',
        string $estado = '',
        ?int $asistentes = null,
        string $descripcion = '',
        string $fecha = ''
    ) {
        $this->idActividad = $idActividad;
        $this->idAdmin = $idAdmin;
        $this->organizador = $organizador;
        $this->categoria = $categoria;
        $this->estado = $estado;
        $this->asistentes = $asistentes;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
    }

    //getters
    public function getIdActividad(): ?int { return $this->idActividad;}
    public function getIdAdmin(): ?int { return $this->idAdmin;}
    public function getOrganizador(): string { return $this->organizador; }
    public function getCategoria(): string { return $this->categoria; }
    public function getEstado(): string { return $this->estado; }
    public function getAsistentes(): ?int { return $this->asistentes; }
    public function getDescripcion(): string { return $this->descripcion; }
    public function getFecha(): string { return $this->fecha; }
    
    //setters
    public function setIdActividad(?int $idActividad): void {
        $this->idActividad = $idActividad;
    }
    public function setIdAdmin(?int $idAdmin): void {
        $this->idAdmin = $idAdmin;
    }
    public function setOrganizador(string $organizador): void {
        $this->organizador = $organizador;
    }
    public function setCategoria(string $categoria): void {
        $this->categoria = $categoria;
    }
    public function setEstado(string $estado): void {
        $this->estado = $estado;
    }
    public function setAsistentes(?int $asistentes): void {
        $this->asistentes = $asistentes;
    }
    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }
    public function setFecha(string $fecha): void {
        $this->fecha = $fecha;
    }

}