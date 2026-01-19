<?php
namespace App\Models\Entities;
use App\Core\baseEntity;

class Ejemplar extends baseEntity {
    private int $id;
    private int $numeroEjemplar;
    private string $estado; // Disponible, Prestado, Descatalogado, En Reparacion
    private bool $activo;
    private int $libroId;

    public function __construct(int $id, int $numeroEjemplar, string $estado, bool $activo, int $libroId) {
        $this->id = $id;
        $this->numeroEjemplar = $numeroEjemplar;
        $this->estado = $estado;
        $this->activo = $activo;
        $this->libroId = $libroId;
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getNumeroEjemplar(): int { return $this->numeroEjemplar; }
    public function getEstado(): string { return $this->estado; }
    public function isActivo(): bool { return $this->activo; }
    public function getLibroId(): int { return $this->libroId; }

    // Setters
    public function setNumeroEjemplar(int $numeroEjemplar): void { $this->numeroEjemplar = $numeroEjemplar; }
    public function setEstado(string $estado): void { $this->estado = $estado; }
    public function setActivo(bool $activo): void { $this->activo = $activo; }

    public static function fromArray(array $data): Ejemplar {
        return new Ejemplar(
            (int)$data['ID_Ejemplar'],
            (int)$data['Numero_Ejemplar'],
            $data['Estado'],
            (bool)$data['Activo'],
            (int)$data['ID_Libro']
        );
    }
}
?>