<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\controllers\AuthController;
use App\controllers\RegisterUserController;
use App\core\Application;
use App\controllers\SiteController;

try {
	$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
	$dotenv->load();
	
	$config = [
		'userClass' => App\models\User::class,
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

	$app = new Application($_ENV['APP_BASE_PATH'] ?? dirname(__DIR__), $config);

	$app->route->get('/', [SiteController::class, 'index']);
	$app->route->get('/products', [SiteController::class, 'index']);

	$app->route->get('/login', [AuthController::class, 'create']);
	$app->route->post('/login', [AuthController::class, 'store']);
	
	$app->route->get('/register', [RegisterUserController::class, 'create']);
	$app->route->post('/register', [RegisterUserController::class, 'store']);
	
	$app->route->get('/profile', [AuthController::class, 'profile']);

	$app->route->get('/logout', [AuthController::class, 'destroy']);

	$app->route->get('/contact', [SiteController::class, 'create']);
	$app->route->post('/contact', [SiteController::class, 'store']);


	$app->route->get('/hello', function () {});

	$app->run();
} catch (\Throwable $th) {

	dd($th);
}
