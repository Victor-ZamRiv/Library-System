<?php
namespace App\Contracts;
use App\Models\Entities\Logro;

interface ILogroRepository {
    public function all(): array;
    public function find(int $id): ?Logro;
    public function insert(Logro $logro): int;
    public function update(Logro $logro): bool;
    public function deactivate(int $id): void;
}