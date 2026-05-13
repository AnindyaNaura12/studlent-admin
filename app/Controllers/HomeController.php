<?php
require_once BASE_PATH . '/core/Controller.php';

class HomeController extends Controller {
    public function index() {
        $this->view('pages/home', ['title' => 'Dashboard Admin']);
    }
}