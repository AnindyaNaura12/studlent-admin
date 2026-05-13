<?php
class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        $controllerName = ucfirst($url[0] ?? 'home') . 'Controller';
        $controllerFile = BASE_PATH . '/app/Controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $this->controller = $controllerName;
        }

        $controller = new $this->controller;
        $this->method = $url[1] ?? 'index';

        if (method_exists($controller, $this->method)) {
            $this->params = array_slice($url, 2);
            call_user_func_array([$controller, $this->method], $this->params);
        }
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return ['home'];
    }
}