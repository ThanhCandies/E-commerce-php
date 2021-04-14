<?php

namespace App\core;

use App\models\User;
use Jenssegers\Blade\Blade;
use Symfony\Component\VarDumper\Cloner\Data;

class Application
{
    public static string $ROOT_DIR;

    public string $layout = 'main';
    public string $footer = 'default';
    public string $header = 'default';
    public string $userClass;
    public Router $route;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?DbModel $user;
    public View $view;
    public Blade $blade;

    public static Application $app;
    public ?Controller $controller = null;

    public function __construct($rootPath, $config)
    {
        $this->userClass = $config['userClass'];

        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->view = new View();
        $this->blade = new Blade($rootPath . '/app/views', $rootPath . '/app/views/cache');

        $this->route = new Router($this->request, $this->response);

        $this->db = new Database($config['connection']);

        // Get session user id = $_SESSION['user'] then get find user info from database;
        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function getController(): object
    {
        return $this->controller;
    }

    public function setController(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    /**
     * @return bool|string|int
     */
    public static function isGuest()
    {
        return !static::$app->user;
    }

    public static function isAdmin(): bool
    {
        return static::$app->user->role === 'admin';
    }

    public function getRoutes(): array
    {
        return $this->route->getRoutes();
    }

    public function run()
    {
        try {
            echo $this->route->resolve();
        } catch (\Exception $exception) {
//            dd($this->route);
            // Throw error when has error while running;
            echo $this->blade->render('pages._error', ['exception' => $exception]);
        }
    }
}
