<?php

namespace app\core;

use PDO;

class Database
{
    public PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigration(): void
    {
        $newMigrations = [];

        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();


        $files = array_diff(scandir(Application::$ROOT_DIR . '/migrations'), array('..', '.'));
        $toApplayMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplayMigrations as $migration) {
            require_once Application::$ROOT_DIR . '/migrations/' . "$migration";

            $className = "app\\migration\\" . pathinfo($migration, PATHINFO_FILENAME);
            $instanse = new $className();

            $this->log("Applying migration $migration");

            $instanse->up();

            $this->log("Applied migration $migration");

            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigration($newMigrations);
        } else {
            $this->log("All migration aplied");
        }
    }

    protected function createMigrationsTable(): void
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    protected function getAppliedMigrations(): array
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    protected function saveMigration(array $migrations): void
    {
        $queryValues = implode(",", array_map(fn($m) => "('$m')", $migrations));

        $statment = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $queryValues");
        $statment->execute();
    }

    protected function log(string $message): void
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}
