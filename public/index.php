<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/core/App.php';

$url = $_GET['url'] ?? '';

if ($url === '') {
    if (isset($_SESSION['admin_id'])) {
        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    } else {
        header('Location: ' . BASE_URL . '/auth/login');
        exit;
    }
}

$app = new App();