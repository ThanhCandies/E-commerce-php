<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\controllers\AuthController;
use App\controllers\RegisterUserController;
use App\core\Application;
use App\controllers\SiteController;
use App\controllers\admin\AdminController;
use App\controllers\admin\ProductController;
use App\models\User;
use App\controllers\admin\CategoryController;
use App\controllers\admin\UsersController;


if (! function_exists('route')) {
    function route(string $name):string
    {
        return Application::$app->route->getPath($name);
    }
}


try {
	$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
	$dotenv->load();
	
	$config = [
		'userClass' => User::class,
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
    // Initial application;
	$app = new Application($_ENV['APP_BASE_PATH'] ?? dirname(__DIR__), $config);

	// Register route here.
	$app->route->get('/', [SiteController::class, 'index'])->name('home');
	$app->route->get('/products', [SiteController::class, 'index']);
	$app->route->get('/login', [AuthController::class, 'create']);
	$app->route->post('/login', [AuthController::class, 'store']);
	
	$app->route->get('/register', [RegisterUserController::class, 'create']);
	$app->route->post('/register', [RegisterUserController::class, 'store']);
	
	$app->route->get('/profile', [AuthController::class, 'profile']);

	$app->route->get('/logout', [AuthController::class, 'destroy']);

	$app->route->get('/contact', [SiteController::class, 'create']);
	$app->route->post('/contact', [SiteController::class, 'store']);

	/** Admin home pages */
	$app->route->get('/admin',[AdminController::class,'index'])->name('admin.home');

    /** Admin products Page   */
	$app->route->get('/admin/products',[ProductController::class,'index'])->name('admin.products');
    $app->route->post('/admin/products',[ProductController::class,'store']);
    $app->route->put('/admin/products',[ProductController::class,'update']);
    $app->route->delete('/admin/products',[ProductController::class,'destroy']);
	/** Admin list users Page */

    $app->route->get('/admin/users',[UsersController::class,'index'])->name('admin.users');

	/** Admin Category */
    $app->route->get('/admin/categories',[CategoryController::class,'index'])->name('admin.categories');
    $app->route->post('/admin/categories',[CategoryController::class,'store']);

    // Start run application;
	$app->run();
} catch (\Throwable $th) {
    // Throw if has error when start application;
	dd($th);
}
