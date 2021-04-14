<?php


namespace App;


use App\core\Application;
use App\core\Router;

class Route
{

    public static array $routes=[];

    protected string $path;

    /**
     * Route constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path=$path;
    }
    public function name($name){
        Application::$app->route->setName($name,$this->path);
    }
}