<?php


namespace App\core\middlewares;


use App\core\Application;
use App\core\exception\NotFoundException;

class AdminMiddleware extends BaseMiddleware
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

        if (!Application::isGuest()&&!Application::isAdmin()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
//                throw new NotFoundException();
                Application::$app->response->redirect('/');
            }
        }
    }
}