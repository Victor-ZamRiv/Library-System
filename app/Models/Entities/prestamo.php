<?php
namespace App\Models\Entities;

use App\Core\baseEntity;

class prestamo extends baseEntity{
    private ?int $idPrestamo = null;
    private int $idLector = 0;
    private int $idAdmin = 0;
    private string $fechaEntrega = '';
    private string $fechaRecepcionEstipulada = '';
    private ?string $fechaRecepcionReal = null;
    private string $estadoEntrega = 'Pendiente';
    private int $renovaciones = 0;
    private bool $activo = true;

    public function __construct(
        ?int $idPrestamo = null,
        int $idLector = 0,
        int $idAdmin = 0,
        string $fechaEntrega = '',
        string $fechaRecepcionEstipulada = '',
        ?string $fechaRecepcionReal = null,
        string $estadoEntrega = 'Pendiente',
        int $renovaciones = 0,
        bool $activo = true
    ) {
        $this->idPrestamo = $idPrestamo;
        $this->idLector = $idLector;
        $this->idAdmin = $idAdmin;
        $this->fechaEntrega = $fechaEntrega;
        $this->fechaRecepcionEstipulada = $fechaRecepcionEstipulada;
        $this->fechaRecepcionReal = $fechaRecepcionReal;
        $this->estadoEntrega = $estadoEntrega;
        $this->renovaciones = $renovaciones;
        $this->activo = $activo;
    }

    //Getters
    public function getIdPrestamo(): ?int { return $this->idPrestamo; }
    public function getIdLector(): int {return $this->idLector; }
    public function getIdAdmin(): int { return $this->idAdmin; }
    public function getFechaEntrega(): string { return $this->fechaEntrega; }
    public function getFechaRecepcionEstipulada(): string { return $this->fechaRecepcionEstipulada; }
    public function getFechaRecepcionReal(): ?string { return $this->fechaRecepcionReal; }
    public function getEstadoEntrega(): string { return $this->estadoEntrega;}
    public function getRenovaciones(): int { return $this->renovaciones; }
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
    public function setFechaEntrega(string $fechaEntrega): void {
        $this->fechaEntrega = $fechaEntrega;
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
    public function setRenovaciones(int $renovaciones): void {
        $this->renovaciones = $renovaciones;
    }
    public function setActivo(bool $activo): void {
        $this->activo = $activo;
    }

}