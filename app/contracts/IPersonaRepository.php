<?php 

namespace App\Contracts;
use App\Models\Entities\Persona;

interface IPersonaRepository {
    public function find(int $id): ?Persona;
    public function findByEmail(?string $email): ?Persona;
    public function findByCedula(string $cedula): ?Persona;
    public function insert(Persona $persona): int;
    public function update(Persona $persona): bool;
}