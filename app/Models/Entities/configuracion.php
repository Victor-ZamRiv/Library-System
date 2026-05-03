<?php

namespace App\Models\Entities;

use App\Core\baseEntity;

class configuracion extends baseEntity
{
    private ?int $idConfiguracion;
    private int $diasPrestamo;
    private int $diasPrestamoNovelas;
    private float $montoMultaDia;
    private int $limitePrestamosSimultaneos;   
    private int $maxRenovaciones;               

    public function __construct(
        ?int $idConfiguracion = null,
        int $diasPrestamo = 0,
        int $diasPrestamoNovelas = 0,
        float $montoMultaDia = 0.0,
        int $limitePrestamosSimultaneos = 0,
        int $maxRenovaciones = 0
    ) {
        $this->idConfiguracion = $idConfiguracion;
        $this->diasPrestamo = $diasPrestamo;
        $this->diasPrestamoNovelas = $diasPrestamoNovelas;
        $this->montoMultaDia = $montoMultaDia;
        $this->limitePrestamosSimultaneos = $limitePrestamosSimultaneos;
        $this->maxRenovaciones = $maxRenovaciones;
    }

    // Getters 
    public function getIdConfiguracion(): ?int { return $this->idConfiguracion; }
    public function getDiasPrestamo(): int { return $this->diasPrestamo; }
    public function getDiasPrestamoNovelas(): int { return $this->diasPrestamoNovelas; }
    public function getMontoMultaDia(): float { return $this->montoMultaDia; }
    public function getLimitePrestamosSimultaneos(): int { return $this->limitePrestamosSimultaneos; }
    public function getMaxRenovaciones(): int { return $this->maxRenovaciones; }

    // Setters
    public function setIdConfiguracion(?int $id): void { $this->idConfiguracion = $id; }
    public function setDiasPrestamo(int $dias): void { $this->diasPrestamo = $dias; }
    public function setDiasPrestamoNovelas(int $dias): void { $this->diasPrestamoNovelas = $dias; }
    public function setMontoMultaDia(float $monto): void { $this->montoMultaDia = $monto; }
    public function setLimitePrestamosSimultaneos(int $limite): void { $this->limitePrestamosSimultaneos = $limite; }
    public function setMaxRenovaciones(int $max): void { $this->maxRenovaciones = $max; }
}