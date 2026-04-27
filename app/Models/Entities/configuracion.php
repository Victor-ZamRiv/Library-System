<?php 
namespace App\Models\Entities;
use App\Core\baseEntity;

class configuracion extends baseEntity {
    private ?int $idConfiguracion;
    private int $diasPrestamo;
    private float $multaDiaria;
    private int $maximoPrestamos;
    private int $limiteRenovaciones;

    public function __construct(
        ?int $idConfiguracion = null,
        int $diasPrestamo = 0,
        float $multaDiaria = 0.0,
        int $maximoPrestamos = 0,
        int $limiteRenovaciones = 0
    ) {
        $this->idConfiguracion = $idConfiguracion;
        $this->diasPrestamo = $diasPrestamo;
        $this->multaDiaria = $multaDiaria;
        $this->maximoPrestamos = $maximoPrestamos;
        $this->limiteRenovaciones = $limiteRenovaciones;
    }

    // Getters
    public function getIdConfiguracion(): ?int { return $this->idConfiguracion; }
    public function getDiasPrestamo(): int { return $this->diasPrestamo; }
    public function getMultaDiaria(): float { return $this->multaDiaria; }
    public function getMaximoPrestamos(): int { return $this->maximoPrestamos; }
    public function getLimiteRenovaciones(): int { return $this->limiteRenovaciones; }

    // Setters
    public function setIdConfiguracion(?int $id): void { $this->idConfiguracion = $id; }
    public function setDiasPrestamo(int $dias): void { $this->diasPrestamo = $dias; }
    public function setMultaDiaria(float $multa): void { $this->multaDiaria = $multa; }
    public function setMaximoPrestamos(int $maximo): void { $this->maximoPrestamos = $maximo; }
    public function setLimiteRenovaciones(int $limite): void { $this->limiteRenovaciones = $limite; }
}