<?php
namespace App\Contracts;
use App\Models\Entities\pregunta;
interface IPreguntaRepository {
    public function all(): array;
    public function find(int $id): ?pregunta;
}