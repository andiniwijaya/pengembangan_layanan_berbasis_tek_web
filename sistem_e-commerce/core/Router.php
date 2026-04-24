<?php

class Router {

    public static function route(){

        $url = $_GET['url'] ?? 'auth/login';

        $url = explode('/', $url);

        $controllerName = ucfirst($url[0]) . 'Controller';
        $method = $url[1] ?? 'index';

        $controllerPath = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

        // cek controller
        if(!file_exists($controllerPath)){
            die("Controller tidak ditemukan");
        }

        require_once $controllerPath;

        $controller = new $controllerName;

        // cek method
        if(!method_exists($controller, $method)){
            die("Method tidak ditemukan");
        }

        call_user_func([$controller, $method]);
    }
}