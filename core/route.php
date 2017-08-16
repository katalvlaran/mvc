<?php

namespace core;


class Route
{
    static function start()
    {

        $routes = explode('/', $_SERVER['REQUEST_URI']);
        $controllerName = !empty($routes[1]) ? $routes[1] : 'Main';
        $actionName = !empty($routes[2]) ? $routes[2] : 'index';

        $modelName = ucfirst(strtolower($controllerName)) . 'Model';
        $controllerName = ucfirst(strtolower($controllerName)) . 'Controller';
        $actionName = 'action'.ucfirst(strtolower($actionName));

        $modelFile = "app/Models/$modelName.php";
        file_exists($modelFile) ? include $modelFile : false ;

        $controllerFile = "app/Controllers/$controllerName.php";
        file_exists($controllerFile) ? include $controllerFile : Route::ErrorPage404($controllerName);

        $controller = new $controllerName;
        method_exists($controller, $actionName) ? $controller->$actionName() : Route::ErrorPage404($controllerName . '->' . $actionName);

    }

    function ErrorPage404($error)
    {
        echo "Ошибка! $error ненайдено<br>";
//        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
//        header('HTTP/1.1 404 Not Found');
//        header("Status: 404 Not Found");
//        header('Location:'.$host.'404');
    }
}