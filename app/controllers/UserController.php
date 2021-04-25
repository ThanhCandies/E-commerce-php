<?php


namespace App\controllers;


use App\core\Controller;
use App\core\Request;
use App\models\User;
use App\core\middlewares\UserMiddleware;

class UserController extends Controller
{

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->registerMiddleware(new UserMiddleware(['profile']));
    }

    public function profile()
    {

        return json_encode(User::where('role', '!=', 1));

    }
}