<?php
namespace App\Core;

use PDO;

abstract class BaseRepository {
    protected PDO $pdo;
    protected string $table;
    protected string $primaryKey;

    public function __construct(PDO $pdo, string $table, string $primaryKey = 'id') {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

    public function all(): array {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} WHERE Activo = 1");
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => $this->mapToEntity($row), $rows);
    }

    public function find(int $id): ?object {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? $this->mapToEntity($row) : null;
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
        return $stmt->execute([$id]);
    }

    protected function runFilteredQuery(string $baseSql, array $params): array {
        $stmt = $this->pdo->prepare($baseSql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => $this->mapToEntity($row), $rows);
    }

    abstract protected function mapToEntity(array $row): object;

    public function getPdo(): PDO {
        return $this->pdo;
    }

}