<?php
namespace App\Models\Entities;
use App\Core\baseEntity;

class Ejemplar extends baseEntity {
    private ?int $idEjemplar;
    private int $numeroEjemplar;
    private string $estado; // Disponible, Prestado, Descatalogado, En Reparacion
    private bool $activo;
    private int $idLibro;

    public function __construct(
        ?int $id = null, 
        int $numeroEjemplar = 0, 
        string $estado = 'Disponible', 
        bool $activo = true, 
        int $idLibro = 0
    ) { 
        $this->idEjemplar = $id; $this->numeroEjemplar = $numeroEjemplar; 
        $this->estado = $estado; $this->activo = $activo; 
        $this->idLibro = $idLibro;
    }

    // Getters
    public function getIdEjemplar(): ?int { return $this->idEjemplar; }
    public function getNumeroEjemplar(): int { return $this->numeroEjemplar; }
    public function getEstado(): string { return $this->estado; }
    public function isActivo(): bool { return $this->activo; }
    public function getLibroId(): int { return $this->idLibro; }

    // Setters
    public function setIdEjemplar(?int $idEjemplar): void { $this->idEjemplar = $idEjemplar; }
    public function setNumeroEjemplar(int $numeroEjemplar): void { $this->numeroEjemplar = $numeroEjemplar; }
    public function setEstado(string $estado): void { $this->estado = $estado; }
    public function setActivo(bool $activo): void { $this->activo = $activo; }
    public function setIdLibro(int $idLibro): void { $this->idLibro = $idLibro; }

    /*public static function fromArray(array $data): Ejemplar {
        return new Ejemplar(
            (int)$data['ID_Ejemplar'],
            (int)$data['Numero_Ejemplar'],
            $data['Estado'],
            (bool)$data['Activo'],
            (int)$data['ID_Libro']
        );
    }*/
}
?>