<?php

class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);

        $viewPath = __DIR__ . '/../app/views/' . $view . '.php';

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die('La vista no existe: ' . $viewPath);
        }
    }

    protected function redirect($url)
    {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
}