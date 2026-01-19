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

    protected function fetchById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function deactivate (int $id): void {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET Activo = 0 WHERE {$this->primaryKey} = ?");
        $stmt->execute([$id]);
    }

    protected function delete(int $id): bool {
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