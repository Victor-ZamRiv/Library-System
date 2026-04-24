<?php
namespace App\Contracts;
use App\Models\Entities\VisitantesRegistro;

interface IVisitanteRepository {
    public function all(): array;
    public function find(int $id): ?VisitantesRegistro;
    public function insert(VisitantesRegistro $visitante): int;
    public function update(VisitantesRegistro $visitante): bool;
    public function existsBySalaFechaTurno(string $idSala, string $fecha, string $turno): bool;
    public function deactivate(int $id): void;
}