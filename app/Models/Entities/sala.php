<?php
namespace App\Models\Entities;
use App\Core\baseEntity;

class Sala extends baseEntity {
    private string $idSala = '';
    private string $nombre = '';
    private int $capacidad = 0;
    private int $disponible = 1;

    public function __construct(string $idSala = '', string $nombre = '', int $capacidad = 0, int $disponible = 1) {
        $this->idSala = $idSala;
        $this->nombre = $nombre;
        $this->capacidad = $capacidad;
        $this->disponible = $disponible;
    }

    // Getters
    public function getIdSala(): string { return $this->idSala;}
    public function getNombre(): string { return $this->nombre; }
    public function getCapacidad(): int { return $this->capacidad; }
    public function getDisponible(): int { return $this->disponible; }

    // Setters
    public function setIdSala(string $idSala): void { $this->idSala = $idSala; }
    public function setNombre(string $nombre): void { $this->nombre = $nombre; }
    public function setCapacidad(int $capacidad): void { $this->capacidad = $capacidad; }
    public function setDisponible(int $disponible): void { $this->disponible = $disponible; }
}