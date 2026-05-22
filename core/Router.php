<?php

class Router
{
    private $controller = 'AuthController';
    private $method = 'login';
    private $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        if (isset($url[0]) && $url[0] !== '') {
            $controllerName = ucfirst($url[0]) . 'Controller';
            $controllerPath = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

            if (file_exists($controllerPath)) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }

        require_once __DIR__ . '/../app/controllers/' . $this->controller . '.php';

        $this->controller = new $this->controller();

        if (isset($url[1]) && $url[1] !== '') {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }

        return [];
    }
}