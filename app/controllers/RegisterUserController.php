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
        return $this->render('pages.auth.register');
    }

	public function store(Request $request)
	{
		$user = User::fill($request->getBody());
//		$user->loadData();

		header("Content-type:application/json");
		if ($user->validate() && $user->save()) {

			$role = $user->role ?? 'user';
			return json_encode(["success" => $user->isSuccess(), "redirect" => $role === 'user' ? "/" : "/admin"]);
		}

		return json_encode(["success" => $user->isSuccess(), "err" => $user->getErrors()]);

	}
}
