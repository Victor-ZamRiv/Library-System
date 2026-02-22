<?php
namespace App\Contracts;
use App\Models\Entities\ConsultaRegistro;
interface IConsultaRepository {
    public function all(): array;
    public function find(int $id): ?ConsultaRegistro;
    public function findBySalaAndFecha(string $idSala, string $fecha): array;
    public function existsBySalaFechaTurnoArea(string $idSala, string $fecha, string $turno, string $idArea): bool;
    public function insert(ConsultaRegistro $consulta): int;
    public function update(ConsultaRegistro $consulta): bool;
    public function deactivate(int $id): void;
}