<?php

namespace App\core;

use App\core\exception\QueryException;
use PDO;

class Database
{
    public $pdo;
    protected int $fetchMode = PDO::FETCH_OBJ;

    public function __construct($config)
    {
        $this->open($config['mysql']);
    }

    public function __destruct()
    {
        $this->close();
    }

    private function open(array $config)
    {
        $this->pdo = new PDO(
            $this->getConnectionString($config),
            $config['username'],
            $config['password']
        );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function close()
    {
        $this->pdo = null;
    }

    public final function execute($sql): bool|int
    {
        return $this->pdo->exec($sql);
    }

    protected function getConnectionString(array $config): string
    {
        return $config['driver'] . ':dbname=' . $config['database'] . ';host=' . $config['host'] . ';port=' . $config['port'];
    }

    public function getPdo():\PDO
    {
        if ($this->pdo instanceof \Closure) {
            return $this->pdo = call_user_func($this->pdo);
        }

        return $this->pdo;
    }

    public function select($query, $bindings = []){
        return $this->run($query, $bindings, function ($query, $bindings) {
//            dump($query);
            $statement = $this->prepared(
                $this->pdo->prepare($query)
            );

            $this->bindValues($statement, $this->prepareBindings($bindings));

            $statement->execute();

            return $statement->fetchAll();
        });
    }
    protected function run($query, $bindings, \Closure $callback)
    {
        try {
            $result = $callback($query, $bindings);
        } catch (QueryException $e) {
            throw $e;
        }

        return $result;
    }
    public function setFetchMode(int $fetchMode){
        $this->fetchMode=$fetchMode;
    }
    protected function prepared(\PDOStatement $statement): \PDOStatement
    {
        $statement->setFetchMode($this->fetchMode);

        return $statement;
    }
    public function bindValues($statement, $bindings)
    {
//        dump($statement,$bindings);
        foreach ($bindings as $key => $value) {
            $statement->bindValue(
                is_string($key) ? $key : $key + 1,
                $value,
                is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR
            );
        }
    }
    public function prepareBindings(array $bindings):array
    {
        foreach ($bindings as $key => $value) {

            if ($value instanceof \DateTimeInterface) {
                $bindings[$key] = $value->format('Y-m-d H:i:s');
            } elseif (is_bool($value)) {
                $bindings[$key] = (int) $value;
            }
        }

        return $bindings;
    }


    /**
     * Apply migration to database (create table in database);
     */
    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $files = scandir(Application::$ROOT_DIR . '/app/migrations');

        $toApplyMigrations = array_diff($files, $appliedMigrations);

        $newMigrations = [];
        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }
            require_once Application::$ROOT_DIR . '/app/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");
            $newMigrations[] = $migration;
        };
        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations are applied");
        }
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
			id INT AUTO_INCREMENT PRIMARY KEY,
			migration VARCHAR(256),
			create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		) ENGINE=INNODB;");
    }

    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration from migrations");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations)
    {

        $str = implode(",", array_map(fn($m) => "('$m')", $migrations));

        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
        $statement->execute();
    }

    protected function log($message)
    {
        echo '[' . date('Y-m-d H:i:s') . ']' . $message . PHP_EOL;
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
}
