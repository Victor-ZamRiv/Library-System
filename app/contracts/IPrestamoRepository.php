<?php
namespace App\Contracts;

use App\Models\Entities\Prestamo;

interface IPrestamoRepository
{
    public function insert(Prestamo $prestamo): int;
    public function update(Prestamo $prestamo): bool;
    public function find(int $id): ?Prestamo;
    public function findPrestamosActivosByLector(int $idLector): array;
    public function findPrestamosActivosByEjemplar(int $idEjemplar): ?Prestamo;
    public function registrarDevolucion(int $idPrestamo, string $fechaReal, string $estado): bool;
    public function all(): array; // opcional, si quieres listar todos
}