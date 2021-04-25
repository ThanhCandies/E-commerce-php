<?php


namespace App\controllers\admin;


use App\core\Application;
use App\core\Controller;
use App\core\middlewares\AdminMiddleware;
use App\core\middlewares\AuthMiddleware;

class AdminController extends Controller
{
    public function __construct()
    {
//        $this->registerMiddleware(new AuthMiddleware([]));
        $this->registerMiddleware(new AdminMiddleware([]));
    }
    public function index(): string
    {
        return $this->render('pages.admin.dashboard');
    }

}