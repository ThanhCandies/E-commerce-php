<?php
if (! function_exists('class_basename')) {
    function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}
if (! function_exists('session')) {
    function session()
    {
        return \App\core\Application::$app->session;
    }
}
