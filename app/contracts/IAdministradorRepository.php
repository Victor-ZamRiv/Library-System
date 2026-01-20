<?php

namespace App\Contracts;
use App\Models\Entities\Administrador;

interface IAdministradorRepository {
    public function all(): array;
    public function find(int $id): ?Administrador;
    public function insert(Administrador $Administrador): int;
    public function update(Administrador $Administrador): bool;
    public function findByUsername(string $username): ?Administrador;
    public function findByEmail(string $email): ?Administrador;
    public function deactivate(int $id): void;
}