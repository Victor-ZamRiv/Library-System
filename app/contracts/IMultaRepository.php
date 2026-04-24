<?php

namespace App\Contracts;

use App\Models\Entities\Multa;

interface IMultaRepository
{
    public function insert(Multa $multa): int;
    public function update(Multa $multa): bool;
    public function find(int $id): ?Multa;
    public function findByPrestamo(int $idPrestamo): ?Multa;
    public function findPendientesByLector(int $idLector): array;
    public function marcarPagada(int $idMulta, string $fechaCancelacion): bool;
    public function marcarCancelada(int $idMulta): bool;
}