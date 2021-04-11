<?php

namespace App\controllers;

use App\core\Application;
use App\core\Controller;
use App\core\Request;
use app\core\Response;
use App\models\User;

class RegisterUserController extends Controller
{

	public function create()
	{
		$this->setLayout('auth');
		return $this->render('pages/register');
	}

	public function store(Request $request)
	{
		$user = new User();
		$user->loadData($request->getBody());

		header("Content-type:application/json");
		if ($user->validate() && $user->save()) {

			$role = $user->role ?? 'user';
			return json_encode(["success" => $user->success, "redirect" => $role === 'user' ? "/" : "/admin"]);
		}

		return json_encode(["success" => $user->success, "err" => $user->errors]);

	}
}
