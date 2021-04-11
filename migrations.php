<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\core\Application;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
	'connection' => [
		'mysql' => [
			'driver' => $_ENV['DB_CONNECTION'] ?? 'mysql',
			'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
			'port' => $_ENV['DB_PORT'] ?? '3306',
			'database' => $_ENV['DB_DATABASE'] ?? 'forge',
			'username' => $_ENV['DB_USERNAME'] ?? 'root',
			'password' => $_ENV['DB_PASSWORD'] ?? ''
		]
	]
];
$app = new Application($_ENV['APP_BASE_PATH'] ?? __DIR__, $config);

$app->db->applyMigrations();
