<?php

namespace App\Models\Entities;

use App\Core\baseEntity;

class Multa extends baseEntity
{
    private ?int $idMulta;
    private int $idPrestamo;
    private int $idAdmin;
    private float $monto;
    private ?string $fechaCancelacion; // formato Y-m-d o null
    private string $estado; // 'Pendiente', 'Pagada', 'Cancelada'

    public function __construct(
        ?int $idMulta = null,
        int $idPrestamo = 0,
        int $idAdmin = 0,
        float $monto = 0.0,
        ?string $fechaCancelacion = null,
        string $estado = 'Pendiente'
    ) {
        $this->idMulta = $idMulta;
        $this->idPrestamo = $idPrestamo;
        $this->idAdmin = $idAdmin;
        $this->monto = $monto;
        $this->fechaCancelacion = $fechaCancelacion;
        $this->estado = $estado;
    }

    // Getters
    public function getIdMulta(): ?int { return $this->idMulta; }
    public function getIdPrestamo(): int { return $this->idPrestamo; }
    public function getIdAdmin(): int { return $this->idAdmin; }
    public function getMonto(): float { return $this->monto; }
    public function getFechaCancelacion(): ?string { return $this->fechaCancelacion; }
    public function getEstado(): string { return $this->estado; }

    // Setters 
    public function setIdMulta(?int $idMulta): void { $this->idMulta = $idMulta; }
    public function setIdPrestamo(int $idPrestamo): void { $this->idPrestamo = $idPrestamo; }
    public function setIdAdmin(int $idAdmin): void { $this->idAdmin = $idAdmin; }

    public function setMonto(float $monto): void
    {
        if ($monto < 0) {
            throw new \InvalidArgumentException("El monto de la multa no puede ser negativo.");
        }
        $this->monto = $monto;
    }

    public function setFechaCancelacion(?string $fechaCancelacion): void
    {
        if ($fechaCancelacion !== null && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaCancelacion)) {
            throw new \InvalidArgumentException("Formato de fecha inválido (YYYY-MM-DD).");
        }
        $this->fechaCancelacion = $fechaCancelacion;
    }

    public function setEstado(string $estado): void
    {
        $estadosPermitidos = ['Pendiente', 'Pagada', 'Cancelada'];
        if (!in_array($estado, $estadosPermitidos)) {
            throw new \InvalidArgumentException("Estado de multa no válido.");
        }
        $this->estado = $estado;
    }

    // Método helper para saber si está pagada o cancelada
    public function isResuelta(): bool
    {
        return in_array($this->estado, ['Pagada', 'Cancelada']);
    }
}