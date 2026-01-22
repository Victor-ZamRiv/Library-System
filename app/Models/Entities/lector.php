<?php
namespace App\Models\Entities;

class Lector extends Persona {
    private ?int $idLector;
    private ?string $carnet;
    private ?string $sexo;
    private ?string $direccion;
    private ?string $ocupacion;
    private ?string $telefonoOcupacion;
    private ?string $direccionOcupacion;
    private ?string $refPersonal;
    private ?string $refPersonalTel;
    private ?string $refLaboral;
    private ?string $refLaboralTel;
    private ?string $estado; // Activo, Inactivo, Inhabilitado
    private ?string $vencimientoCarnet;
    private Persona $persona;

    public function __construct(
        ?int $idLector = null,
        int $idPersona = 0,
        ?string $carnet = null,
        ?string $sexo = null,
        ?string $direccion = null,
        ?string $ocupacion = null,
        ?string $telefonoOcupacion = null,
        ?string $direccionOcupacion = null,
        ?string $refPersonal = null,
        ?string $refPersonalTel = null,
        ?string $refLaboral = null,
        ?string $refLaboralTel = null,
        ?string $estado = null,
        ?string $vencimientoCarnet = null
    ) {
        parent::__construct($idPersona); // hereda datos de persona
        $this->idLector = $idLector;
        $this->carnet = $carnet;
        $this->sexo = $sexo;
        $this->direccion = $direccion;
        $this->ocupacion = $ocupacion;
        $this->telefonoOcupacion = $telefonoOcupacion;
        $this->direccionOcupacion = $direccionOcupacion;
        $this->refPersonal = $refPersonal;
        $this->refPersonalTel = $refPersonalTel;
        $this->refLaboral = $refLaboral;
        $this->refLaboralTel = $refLaboralTel;
        $this->estado = $estado;
        $this->vencimientoCarnet = $vencimientoCarnet;
    }

    // Getters
    public function getIdLector(): ?int { return $this->idLector; }
    public function getCarnet(): ?string { return $this->carnet; }
    public function getSexo(): ?string { return $this->sexo; }
    public function getDireccion(): ?string { return $this->direccion; }
    public function getOcupacion(): ?string { return $this->ocupacion; }
    public function getTelefonoOcupacion(): ?string { return $this->telefonoOcupacion; }
    public function getDireccionOcupacion(): ?string { return $this->direccionOcupacion; }
    public function getRefPersonal(): ?string { return $this->refPersonal; }
    public function getRefPersonalTel(): ?string { return $this->refPersonalTel; }
    public function getRefLaboral(): ?string { return $this->refLaboral; }
    public function getRefLaboralTel(): ?string { return $this->refLaboralTel; }
    public function getEstado(): ?string { return $this->estado; }
    public function getVencimientoCarnet(): ?string { return $this->vencimientoCarnet; }
    public function getPersona(): Persona { return $this->persona; }
    // Setters
    public function setCarnet(?string $carnet): void { $this->carnet = $carnet; }
    public function setSexo(?string $sexo): void { $this->sexo = $sexo; }
    public function setDireccion(?string $direccion): void { $this->direccion = $direccion; }
    public function setOcupacion(?string $ocupacion): void { $this->ocupacion = $ocupacion; }
    public function setTelefonoOcupacion(?string $telefonoOcupacion): void { $this->telefonoOcupacion = $telefonoOcupacion; }
    public function setDireccionOcupacion(?string $direccionOcupacion): void { $this->direccionOcupacion = $direccionOcupacion; }
    public function setRefPersonal(?string $refPersonal): void { $this->refPersonal = $refPersonal; }
    public function setRefPersonalTel(?string $refPersonalTel): void { $this->refPersonalTel = $refPersonalTel; }
    public function setRefLaboral(?string $refLaboral): void { $this->refLaboral = $refLaboral; }
    public function setRefLaboralTel(?string $refLaboralTel): void { $this->refLaboralTel = $refLaboralTel; }
    public function setEstado(?string $estado): void { $this->estado = $estado; }
    public function setVencimientoCarnet(?string $vencimientoCarnet): void { $this->vencimientoCarnet = $vencimientoCarnet; }
    public function setPersona(Persona $persona): void { $this->persona = $persona; }

}