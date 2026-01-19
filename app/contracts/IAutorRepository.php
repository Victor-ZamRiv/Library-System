<?php
namespace App\Contracts;

use App\Models\Entities\Autor;

interface IAutorRepository {
    public function find(int $id): ?Autor;
    public function insert(Autor $autor): int;
    public function deleteRelacionesPorLibro(int $idLibro): bool;
    public function vincularConLibro(int $idLibro, int $idAutor): bool;
    public function getAutoresLibro(int $idLibro): array;
    public function findByName(string $nombre): ?Autor;
}