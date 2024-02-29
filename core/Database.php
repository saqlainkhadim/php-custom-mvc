<?php


namespace app\core;


class Database
{
    public \PDO $pdo;

    public function __construct(array $config)
    {
        $this->pdo = new \PDO($config['dsn'], $config['user'], $config['password']);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function prepare(string $sql)
    {
        return $this->pdo->prepare($sql);
    }

    public function applyMigrations()
    {
        $this->createMigrationTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $files = scandir(Application::$ROOT_DIR . '/migrations');

        $toApplyMigrations = array_diff($files, $appliedMigrations);
        $migrationsApplied = [];

        foreach ($toApplyMigrations as $migration) {

            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once Application::$ROOT_DIR . "/migrations/" . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();

            $this->log("applying Migration $migration");
            $instance->up();
            $this->log("applied Migration $migration");

            $migrationsApplied[] = $migration;


        }

        if(!empty($migrationsApplied)){
            $this->saveMigration($migrationsApplied);
        }

        $this->log("All migrations are applied.");

    }

    private function createMigrationTable()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS migrations(
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;
        ");
    }

    private function getAppliedMigrations(): array
    {
        $statement = $this->pdo->prepare("Select migration from migrations;");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    private function log(string $message)
    {
        echo "[ " . date('Y-m-d H:m:s') . " ] - " . $message . PHP_EOL;
    }

    private function saveMigration(array $migrations)
    {
        $str = implode(",", array_map(fn($m) => "('$m')", $migrations));
        $statement = $this->pdo->prepare(" INSERT INTO migrations (migration) VALUES $str ;");
        $statement->execute();
    }


}