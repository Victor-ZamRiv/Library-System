<?php
namespace App\Contracts;

use App\Models\Entities\Libro;

interface ILibroRepository {
    public function search(array $filtros): array;
    public function insert(Libro $libro): int;
    public function associateAutor(int $idLibro, int $idAutor): bool;
    public function update(Libro $libro): bool;
    public function find(int $id): ?Libro;
    public function existsCota(string $cota): bool;
}