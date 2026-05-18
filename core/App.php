<?php
class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        $controllerName = ucfirst(strtolower($url[0] ?? 'home')) . 'Controller';
        $controllerFile = BASE_PATH . '/app/Controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $this->controller = $controllerName;
        } else {
            // Controller tidak ditemukan → 404
            http_response_code(404);
            echo '404 - Halaman tidak ditemukan';
            return;
        }

        $controller = new $this->controller;

        // Method dari URL segment ke-2, default 'index'
        $this->method = isset($url[1]) && !empty($url[1]) ? $url[1] : 'index';

        if (method_exists($controller, $this->method)) {
            $this->params = array_slice($url, 2);
            call_user_func_array([$controller, $this->method], $this->params);
        } else {
            http_response_code(404);
            echo '404 - Method tidak ditemukan';
        }
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return ['home'];
    }
}