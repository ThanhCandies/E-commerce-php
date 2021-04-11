<?php

namespace App\controllers;

use App\core\Application;
use App\core\Controller;
use App\core\Request;
use app\core\Response;
use App\models\LoginForm;

class AuthController extends Controller
{

	public function __construct()
	{
		$this->registerMiddleware(new AuthMiddleware());
	}

	public function create()
	{
		// return microtime(true);
		$this->setLayout("auth");
		return $this->render('pages/login');
	}

	public function store(Request $request, Response $response)
	{
		$user = new LoginForm();
		$user->loadData($request->getBody());

		header("Content-type:application/json");
		if ($user->validate() && $user->authenticate()) {

			$role = $user->role ?? 'user';
			return json_encode(["success" => $user->success, "redirect" => $role === 'user' ? "/" : "/admin"]);
		}

		return json_encode(["success" => $user->success, "err" => $user->errors]);
	}

	public function profile()
	{
		return $this->render('pages/profile');
	}

	public function destroy(Request $request, Response $response)
	{
		$response->redirect('/login');
		Application::$app->logout();
		return true;
	}
}
