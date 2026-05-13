<?php
class Controller {
    protected function view($view, $data = []) {
        extract($data);
        $file = BASE_PATH . '/app/Views/' . $view . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }

    protected function model($model) {
        require_once BASE_PATH . '/app/Models/' . $model . '.php';
        return new $model();
    }
}