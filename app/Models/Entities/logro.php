<?php
namespace App\Models\Entities;

use App\Core\baseEntity;

class Logro extends baseEntity {

    private ?int $idLogro;
    private ?int $idAdmin;
    private string $descripcion;
    private string $involucrados;
    private string $fecha;

    public function __construct(
        ?int $idLogro = null,
        ?int $idAdmin = null,
        string $descripcion = '',
        string $involucrados = '',
        string $fecha = ''
    ) {
        $this->idLogro = $idLogro;
        $this->idAdmin = $idAdmin;
        $this->descripcion = $descripcion;
        $this->involucrados = $involucrados;
        $this->fecha = $fecha;
    }

    // Getters
    public function getIdLogro(): ?int { return $this->idLogro; }
    public function getIdAdmin(): ?int { return $this->idAdmin; }
    public function getDescripcion(): string { return $this->descripcion; }
    public function getInvolucrados(): string { return $this->involucrados; }
    public function getFecha(): string { return $this->fecha; }

    // Setters
    public function setIdLogro(?int $idLogro): void { $this->idLogro = $idLogro; }
    public function setIdAdmin(?int $idAdmin): void { $this->idAdmin = $idAdmin; }
    public function setDescripcion(string $descripcion): void { $this->descripcion = $descripcion; }
    public function setInvolucrados(string $involucrados): void { $this->involucrados = $involucrados; }
    public function setFecha(string $fecha): void { $this->fecha = $fecha; }
}
