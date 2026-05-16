<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

// Hapus prefix folder jika ada (misal: studlent/public)
$basePath = trim(dirname($_SERVER['SCRIPT_NAME']), '/');
if ($basePath && str_starts_with($uri, $basePath)) {
    $uri = trim(substr($uri, strlen($basePath)), '/');
}

require_once BASE_PATH . '/app/Controllers/AuthController.php';
require_once BASE_PATH . '/app/Controllers/HomeController.php';
require_once BASE_PATH . '/app/Controllers/DashboardController.php';

$routes = [
    ''          => [HomeController::class, 'index'],
    'dashboard' => [DashboardController::class, 'index'],
    'login'     => [AuthController::class, 'index'],
];

if (array_key_exists($uri, $routes)) {
    [$class, $method] = $routes[$uri];
    $controller = new $class();
    $controller->$method();
} else {
    http_response_code(404);
    echo '404 - Halaman tidak ditemukan';
}