<?php
namespace App\Contracts;
use App\Models\Entities\Ejemplar;
interface IEjemplarRepository {
    public function insert(array $ejemplar): int;
    public function updateEstado(Ejemplar $ejemplar): bool;
    public function findByLibro(int $id): array;
    public function find(int $id): ?Ejemplar;
    public function deactivate(int $id): void;
    public function getMaxNumeroEjemplar(int $idLibro): int;
}