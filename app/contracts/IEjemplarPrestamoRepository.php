<?php
namespace App\Contracts;

interface IEjemplarPrestamoRepository
{
    public function associate(int $idPrestamo, int $idEjemplar): bool;
    public function findByPrestamo(int $idPrestamo): array;
    public function findByEjemplar(int $idEjemplar): ?int;
}