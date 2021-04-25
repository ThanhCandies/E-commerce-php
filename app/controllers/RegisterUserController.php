<?php

namespace App\controllers;

use App\core\Application;
use App\core\Controller;
use App\core\middlewares\AuthMiddleware;
use App\core\Request;
use app\core\Response;
use App\models\User;

class RegisterUserController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware([]));
    }

	public function create()
	{
        return $this->render('pages.auth.register');
    }

	public function store(Request $request)
	{
		$user = User::create($request->getBody());
//        dump($user);
		header("Content-type:application/json");
		if ($user->validate() && ($id = $user->save())) {
			$role = $user->role ?? 'user';
            Application::$app->session->set('user', $id);

			return json_encode(["success" => $user->isSuccess(), "redirect" => $role === 'user' ? "/" : "/admin"]);
		}

		return json_encode(["success" => $user->isSuccess(), "err" => $user->getErrors()]);

	}
}
