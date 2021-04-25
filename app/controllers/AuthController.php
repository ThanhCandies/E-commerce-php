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
        $this->registerMiddleware(new AuthMiddleware([]));
    }

    public function create():string
    {
        return $this->render('pages.auth.login');
    }

    public function login(Request $request, Response $response)
    {
        $user = new LoginForm();
        $user->fill($request->getBody());

        header("Content-type:application/json");

        if ($user->validate() && $user->authenticate()) {

            $role = $user->role_id ?? 2;
            return json_encode(["success" => $user->isSuccess(), "redirect" =>(int) $role === 1 ? "/admin" : "/"]);
        }

        return json_encode(["success" => $user->isSuccess(), "err" => $user->getErrors()]);
    }


    public function destroy(Request $request, Response $response)
    {
        $response->redirect('/login');
        Application::$app->logout();
        return true;
    }
}
