<?php
namespace App\Models\Entities;

use App\Models\Entities\Persona;

class Administrador extends Persona {
    private ?int $idAdmin;
    private string $nombreUsuario;
    private string $contrasenaHash;
    private string $rol;
    private bool $activo;

    private ?Persona $persona = null;

    public function __construct(
        ?int $idAdmin = null,
        int $idPersona = 0,
        string $nombreUsuario = '',
        string $contrasenaHash = '',
        string $rol = '',
        bool $activo = true
    ) {
        parent::__construct($idPersona); // hereda datos de persona
        $this->idAdmin = $idAdmin;
        $this->nombreUsuario = $nombreUsuario;
        $this->contrasenaHash = $contrasenaHash;
        $this->rol = $rol;
        $this->activo = $activo;
    }


    // Getters
    public function getIdAdministrador(): ?int { return $this->idAdmin; }
    public function getNombreUsuario(): string { return $this->nombreUsuario; }
    public function getContrasenaHash(): string { return $this->contrasenaHash; }
    public function getRol(): string { return $this->rol; }
    public function isActivo(): bool { return $this->activo; }
    public function getPersona(): ?Persona { return $this->persona; }

    // Setters
    public function setNombreUsuario(string $nombreUsuario): void { $this->nombreUsuario = $nombreUsuario; }
    public function setContrasenaHash(string $hash): void { $this->contrasenaHash = $hash; }
    public function setRol(string $rol): void { $this->rol = $rol; }
    public function setActivo(bool $activo): void { $this->activo = $activo; }
    public function setPersona(Persona $persona): void { $this->persona = $persona; }

    
}


?>