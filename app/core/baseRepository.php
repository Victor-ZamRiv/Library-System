<?php
namespace App\Core;

abstract class baseRepository {
    protected \PDO $pdo;
    protected string $table;

    public function __construct(\PDO $pdo, string $table) {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    abstract public function all(): array;
    abstract public function find(int $id): ?object;
    abstract public function save(object $entity): int;
    abstract public function delete(int $id): bool;
}