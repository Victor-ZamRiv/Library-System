<?php
namespace App\Contracts;
use App\Models\Entities\Editorial;

interface IEditorialRepository {
    public function find(int $id): ?Editorial;
    public function findByName(string $nombre): ?Editorial;
    public function insert(Editorial $editorial): int;
    //public function update(Editorial $editorial): bool;
}