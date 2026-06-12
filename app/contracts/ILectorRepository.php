<?php
namespace App\Contracts;

use App\Models\Entities\Lector;
interface ILectorRepository {
    public function insert(Lector $lector): int;
    public function update(Lector $lector): bool;
    public function find(int $id): ?Lector;
    public function findByCarnet(string $carnet): ?Lector;
    public function findByPersonaId(int $idPersona): ?Lector;
<<<<<<< HEAD
    public function findInactivos(): array;
=======
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
    public function all(): array;
    public function deactivate(int $id): void;
    public function reactivar(int $id): bool;
    public function countInactivos(): int;
    public function search(string $input): array;
    public function listarActivosPaginados(int $pagina, int $porPagina, ?string $search = null): array;
}
