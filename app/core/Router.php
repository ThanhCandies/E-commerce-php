<?php

namespace App\core;

use App\core\exception\NotFoundException;
use App\core\middlewares\BaseMiddleware;
use App\Route;

class Router
{
    protected array $routes = [];
    protected Request $request;
    protected Response $response;
    protected array $nameList = [];

    function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function get($path, $cb): object
    {
        $this->routes['GET'][$path] = $cb;
        return new Route($path);
    }

    public function post($path, $cb): object
    {
        $this->routes['POST'][$path] = $cb;
        return new Route($path);
    }
    public function put($path, $cb): object
    {
        $this->routes['PUT'][$path] = $cb;
        return new Route($path);
    }
    public function path($path, $cb): object
    {
        $this->routes['PATH'][$path] = $cb;
        return new Route($path);
    }
    public function delete($path, $cb): object
    {
        $this->routes['DELETE'][$path] = $cb;
        return new Route($path);
    }

    public function setName($name, $path)
    {
        $this->nameList[$name] = $path;
    }
    public function getPath($name):string
    {
        return $this->nameList[$name]??'';
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $cb = $this->routes[$method][$path] ?? false;
        if (!$cb) {
            throw new NotFoundException();
        };

        if (is_string($cb)) {
//            return Application::$app->view->renderView($cb);
            return Application::$app->blade->render($cb);
        }
        if (is_array($cb)) {
            /**
             * @var Controller $controller
             * @var BaseMiddleware $middleware
             */
            $controller = new $cb[0]();
            Application::$app->controller = $controller;
            $controller->action = $cb[1];
            $cb[0] = Application::$app->controller;

            foreach ($controller->getMiddleware() as $middleware) {
                $middleware->execute();
            }
        }
        return call_user_func($cb, $this->request, $this->response);
    }
}
