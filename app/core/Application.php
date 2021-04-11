<?php

namespace App\core;

use App\models\User;
use Symfony\Component\VarDumper\Cloner\Data;

class Application
{
	public static string $ROOT_DIR;

	// public string $layout = 'main';
	public string $userClass;
	public Router  $route;
	public Request $request;
	public Response $response;
	public Session $session;
	public Database $db;
	public ?DbModel $user;

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

		$this->route = new Router($this->request, $this->response);

		$this->db = new Database($config['connection']);

		$primaryValue = $this->session->get('user');
		if ($primaryValue) {
			$primaryKey = $this->userClass::primaryKey();
			$this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
		} else {
			$this->user = null;
		}
	}

	public function getController()
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
	public static function isGuest()
	{
		return !static::$app->user;
	}

	public function run()
	{
		echo $this->route->resolve();
	}
}
