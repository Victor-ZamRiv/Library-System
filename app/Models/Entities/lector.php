<?php
namespace App\Models\Entities;

class Lector extends Persona {
    private ?int $idLector;
    private ?string $carnet;
    private ?string $sexo;
    private ?string $direccion;
    private ?string $profesion;
    private ?string $telefonoProfesion;
    private ?string $direccionProfesion;
    private ?string $refPersonal;
    private ?string $refPersonalTel;
    private ?string $refLegal;
    private ?string $refLegalTel;
    private ?string $estado; // Activo, Inactivo, Inhabilitado
    private ?string $vencimientoCarnet;
    private Persona $persona;

    public function __construct(
        ?int $idLector = null,
        int $idPersona = 0,
        ?string $carnet = null,
        ?string $sexo = null,
        ?string $direccion = null,
        ?string $profesion = null,
        ?string $telefonoProfesion = null,
        ?string $direccionProfesion = null,
        ?string $refPersonal = null,
        ?string $refPersonalTel = null,
        ?string $refLegal = null,
        ?string $refLegalTel = null,
        ?string $estado = null,
        ?string $vencimientoCarnet = null
    ) {
        parent::__construct($idPersona); // hereda datos de persona
        $this->idLector = $idLector;
        $this->carnet = $carnet;
        $this->sexo = $sexo;
        $this->direccion = $direccion;
        $this->profesion = $profesion;
        $this->telefonoProfesion = $telefonoProfesion;
        $this->direccionProfesion = $direccionProfesion;
        $this->refPersonal = $refPersonal;
        $this->refPersonalTel = $refPersonalTel;
        $this->refLegal = $refLegal;
        $this->refLegalTel = $refLegalTel;
        $this->estado = $estado;
        $this->vencimientoCarnet = $vencimientoCarnet;
    }

    // Getters
    public function getIdLector(): ?int { return $this->idLector; }
    public function getCarnet(): ?string { return $this->carnet; }
    public function getSexo(): ?string { return $this->sexo; }
    public function getDireccion(): ?string { return $this->direccion; }
    public function getProfesion(): ?string { return $this->profesion; }
    public function getTelefonoProfesion(): ?string { return $this->telefonoProfesion; }
    public function getDireccionProfesion(): ?string { return $this->direccionProfesion; }
    public function getRefPersonal(): ?string { return $this->refPersonal; }
    public function getRefPersonalTel(): ?string { return $this->refPersonalTel; }
    public function getRefLegal(): ?string { return $this->refLegal; }
    public function getRefLegalTel(): ?string { return $this->refLegalTel; }
    public function getEstado(): ?string { return $this->estado; }
    public function getVencimientoCarnet(): ?string { return $this->vencimientoCarnet; }
    public function getPersona(): Persona { return $this->persona; }
    // Setters
    public function setCarnet(?string $carnet): void { $this->carnet = $carnet; }
    public function setSexo(?string $sexo): void { $this->sexo = $sexo; }
    public function setDireccion(?string $direccion): void { $this->direccion = $direccion; }
    public function setProfesion(?string $profesion): void { $this->profesion = $profesion; }
    public function setTelefonoProfesion(?string $telefonoProfesion): void { $this->telefonoProfesion = $telefonoProfesion; }
    public function setDireccionProfesion(?string $direccionProfesion): void { $this->direccionProfesion = $direccionProfesion; }
    public function setRefPersonal(?string $refPersonal): void { $this->refPersonal = $refPersonal; }
    public function setRefPersonalTel(?string $refPersonalTel): void { $this->refPersonalTel = $refPersonalTel; }
    public function setRefLegal(?string $refLegal): void { $this->refLegal = $refLegal; }
    public function setRefLegalTel(?string $refLegalTel): void { $this->refLegalTel = $refLegalTel; }
    public function setEstado(?string $estado): void { $this->estado = $estado; }
    public function setVencimientoCarnet(?string $vencimientoCarnet): void { $this->vencimientoCarnet = $vencimientoCarnet; }
    public function setPersona(Persona $persona): void { $this->persona = $persona; }

}