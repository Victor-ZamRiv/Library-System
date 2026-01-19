<?php
namespace App\Models\Entities;

use App\Core\BaseEntity;

class Persona extends BaseEntity {
    private ?int $idPersona;
    private string $cedula;
    private string $nombre;
    private string $apellido;
    private ?string $email;
    private ?string $telefono;

    public function __construct(
        ?int $idPersona = null,
        string $cedula = '',
        string $nombre = '',
        string $apellido = '',
        ?string $email = null,
        ?string $telefono = null
    ) {
        $this->idPersona = $idPersona;
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->telefono = $telefono;
    }

    // Getters
    public function getIdPersona(): ?int { return $this->idPersona; }
    public function getCedula(): string { return $this->cedula; }
    public function getNombre(): string { return $this->nombre; }
    public function getApellido(): string { return $this->apellido; }
    public function getEmail(): ?string { return $this->email; }
    public function getTelefono(): ?string { return $this->telefono; }
    // Setters
    public function setIdPersona(int $idPersona): void { $this->idPersona = $idPersona; }
    public function setNombre(string $nombre): void { $this->nombre = $nombre; }
    public function setCedula(string $cedula): void { $this->cedula = $cedula; }
    public function setApellido(string $apellido): void { $this->apellido = $apellido; }
    public function setEmail(?string $email): void { $this->email = $email; }
    public function setTelefono(?string $telefono): void { $this->telefono = $telefono; }

}