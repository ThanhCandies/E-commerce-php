<?php

namespace App\core;

use App\core\Application;
use App\core\middlewares\BaseMiddleware;

class Controller
{
    public string $layout = "main";
    public string $header = "default";
    public string $footer = "default";
    public string $action = '';
    /**
     * @var App\core\middlewares\BaseMiddleware[];
     */
    public array $middleware = [];

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middleware[] = $middleware;
    }

    public function getMiddleware(): array
    {
        return $this->middleware;
    }
    protected function render($view, $params=[]):string
    {
        return Application::$app->blade->render($view,$params);
    }
}
