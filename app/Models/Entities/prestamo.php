<?php
namespace App\Models\Entities;

use App\Core\baseEntity;

class prestamo extends baseEntity{
    private ?int $idPrestamo;
    private int $idLector;
    private int $idAdmin;
    private string $fechaEntregado;      // fecha en que se prestó
    private string $fechaRecepcionEstipulada;
    private ?string $fechaRecepcionReal;
    private string $estadoEntrega;       // 'Pendiente', 'Devuelto', 'Vencido', 'Perdido'
    private bool $activo;

    //Getters
    public function getIdPrestamo(): ?int { return $this->idPrestamo; }
    public function getIdLector(): int {return $this->idLector; }
    public function getIdAdmin(): int { return $this->idAdmin; }
    public function getFechaEntregado(): string { return $this->fechaEntregado; }
    public function getFechaRecepcionEstipulada(): string { return $this->fechaRecepcionEstipulada; }
    public function getFechaRecepcionReal(): ?string { return $this->fechaRecepcionReal; }
    public function getEstadoEntrega(): string { return $this->estadoEntrega;}
    public function getActivo(): bool { return $this->activo; }
    
    //Setters
    public function setIdPrestamo(?int $idPrestamo): void {
        $this->idPrestamo = $idPrestamo;
    }
    public function setIdLector(int $idLector): void {
        $this->idLector = $idLector;
    }
    public function setIdAdmin(int $idAdmin): void {
        $this->idAdmin = $idAdmin;
    }
    public function setFechaEntregado(string $fechaEntregado): void {
        $this->fechaEntregado = $fechaEntregado;
    }
    public function setFechaRecepcionEstipulada(string $fechaRecepcionEstipulada): void {
        $this->fechaRecepcionEstipulada = $fechaRecepcionEstipulada;
    }
    public function setFechaRecepcionReal(?string $fechaRecepcionReal): void {
        $this->fechaRecepcionReal = $fechaRecepcionReal;
    }
    public function setEstadoEntrega(string $estadoEntrega): void {
        $this->estadoEntrega = $estadoEntrega;
    }
    public function setActivo(bool $activo): void {
        $this->activo = $activo;
    }

}