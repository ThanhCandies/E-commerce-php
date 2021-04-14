<?php

namespace App\controllers;

use App\core\Application;
use App\core\Controller;
use App\core\middlewares\AuthMiddleware;
use App\core\Request;
use app\core\Response;
use App\models\LoginForm;
use App\models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function create():string
    {
//        $this->setLayout("auth");
        return $this->render('pages.auth.login');
    }

    public function store(Request $request, Response $response)
    {
        $user = new LoginForm();
        $user->loadData($request->getBody());

        header("Content-type:application/json");
        if ($user->validate() && $user->authenticate()) {

            $role = $user->role ?? 'user';
            return json_encode(["success" => $user->isSuccess(), "redirect" => $role === 'user' ? "/" : "/admin"]);
        }

        return json_encode(["success" => $user->isSuccess(), "err" => $user->getErrors()]);
    }

    public function profile(Request $request)
    {
        return json_encode(User::findAll(['role']));
	}

    public function destroy(Request $request, Response $response)
    {
        $response->redirect('/login');
        Application::$app->logout();
        return true;
    }
}
