<?php
namespace App\Contracts;

use App\Models\Entities\Lector;
interface ILectorRepository {
    public function insert(Lector $lector): int;
    public function update(Lector $lector): bool;
    public function find(int $id): ?Lector;
    public function all(): array;
    public function deactivate(int $id): void;
    public function search(string $input): array;
}
