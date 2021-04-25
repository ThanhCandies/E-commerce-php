<?php
require_once __DIR__ . '/../vendor/autoload.php';
ini_set('upload_tmp_dir',__DIR__);

use App\controllers\AuthController;
use App\controllers\RegisterUserController;
use App\core\Application;
use App\controllers\SiteController;
use App\controllers\admin\AdminController;
use App\controllers\admin\ProductController;
use App\models\User;
use App\controllers\admin\CategoryController;
use App\controllers\admin\UsersController;
use App\controllers\admin\ImageController;
use App\core\Collections;
use Jenssegers\Blade\Blade;
use JetBrains\PhpStorm\Pure;

if (! function_exists('route')) {
    function route(string $name):string
    {
        return Application::$app->route->getPath($name);
    }
}

if (! function_exists('collect')) {
    #[Pure] function collect($value = null): Collections
    {
        return new Collections($value);
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
	$app->route->get('/', [SiteController::class, 'home'])->name('home');

    $app->route->get('/products', [SiteController::class, 'products']);
    $app->route->get('/category', [SiteController::class, 'category']);

	$app->route->get('/login', [AuthController::class, 'create']);
	$app->route->post('/login', [AuthController::class, 'login']);
	$app->route->get('/logout', [AuthController::class, 'destroy']);

	$app->route->get('/register', [RegisterUserController::class, 'create']);
	$app->route->post('/register', [RegisterUserController::class, 'store']);

	$app->route->get('/contact', [SiteController::class, 'create']);
	$app->route->post('/contact', [SiteController::class, 'store']);

    /** User page */

	$app->route->get('/profile', [UsersController::class, 'profile']);
    $app->route->get('/checkout',[UsersController::class,'checkout']);
    $app->route->get('/order',[UsersController::class,'order']);

    $app->route->post('/addCart',[UsersController::class,'addToCart']);
    $app->route->post('/removeItem',[UsersController::class,'removeItem']);
    $app->route->post('/checkout',[UsersController::class,'placeOrder']);

	/** Admin home pages */
	$app->route->get('/admin',[AdminController::class,'index'])->name('admin.home');

	/** Images upload */
    $app->route->post('/upload/images',[ImageController::class,'store']);

    /** Admin products Page   */
	$app->route->get('/admin/products',[ProductController::class,'index'])->name('admin.products');
	$app->route->get('/api/products',[ProductController::class,'getAll']); // Get list products

    $app->route->post('/admin/products',[ProductController::class,'store'])->name('products.create'); // Create new products
    $app->route->put('/admin/products',[ProductController::class,'update']); //
    $app->route->delete('/admin/products',[ProductController::class,'destroy']);





	/** Admin list users Page */

//    $app->route->get('/admin/users',[UsersController::class,'index'])->name('admin.users');

	/** Admin Category */
    $app->route->get('/api/categories',[CategoryController::class,'show']);

    $app->route->get('/admin/categories',[CategoryController::class,'index'])->name('admin.categories');
    $app->route->post('/admin/categories',[CategoryController::class,'store'])->name('category.create');
    $app->route->delete('/admin/categories',[CategoryController::class,'destroy']);
    /** Test case */

    $app->route->get('/admin/test',[\App\controllers\admin\TestController::class,'index']);
    $app->route->put('/admin/test',[\App\controllers\admin\TestController::class,'put']);
    $app->route->post('/admin/test',[\App\controllers\admin\TestController::class,'post']);
    $app->route->delete('/admin/test',[\App\controllers\admin\TestController::class,'delete']);

    // Start run application;
	$app->run();
} catch (\Throwable $th) {
    dd($th);
    // Throw if has error when start application;
    $blade = new Blade(
       $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__) . '/app/views',
       $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__) . '/app/views/cache');
    echo $blade ->render('pages._error');

//    echo $app->blade->render('pages._error', ['exception' => $th]);
//	dd($th,123);
}
