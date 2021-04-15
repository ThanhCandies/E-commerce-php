<?php

namespace App\core;

use PDO;

class Database
{
	public PDO $pdo;
	public function __construct($config)
	{
		$db = $config['mysql'];
		$driver = $db['driver'];
		$host = $db['host'];
		$port = $db['port'];
		$database = $db['database'];
		$username = $db['username'];
		$password = $db['password'];

		$this->pdo = new PDO("$driver:host=$host;dbname=$database;port=$port", $username, $password);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
		// echo '<pre>';
		// var_dump($toApplyMigrations);
		// echo '</pre>';
		// exit;
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

		$str = implode(",", array_map(fn ($m) => "('$m')", $migrations));

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
