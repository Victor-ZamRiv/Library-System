<?php
namespace App\Contracts;
use App\Models\Entities\Sala;
interface ISalaRepository {
    public function all(): array;
    public function find(string $id): ?Sala;
    public function updateCapacidad(string $idSala, int $capacidad): bool;
    public function updateDisponible(string $idSala, int $disponible): bool;
    public function listDisponibles(): array;
}