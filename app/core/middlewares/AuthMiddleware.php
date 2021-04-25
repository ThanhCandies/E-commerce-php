<?php


namespace App\core\middlewares;


use App\core\Application;
use App\core\exception\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];

    /**
     * AuthMiddleware constructor.
     * @param array $actions // No
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        /**
         *
         */
//        dump('s');
//        echo Application::isGuest();
        if (Application::isGuest()) {
//            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
//                Application::$app->response->redirect('/login');
//            }
        } else {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                Application::$app->response->redirect('/');
//                return;
            }
        }

    }
}