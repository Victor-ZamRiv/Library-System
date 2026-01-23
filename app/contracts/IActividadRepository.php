<?php
namespace App\Contracts;
use App\Models\Entities\Actividad;
interface IActividadRepository {
    public function all(): array;
    //public function search(array $filtros): array;
    public function insert(Actividad $actividad): int;
    public function update(Actividad $actividad): bool;
    public function find(int $id): ?Actividad;
    public function deactivate(int $id): void;
}