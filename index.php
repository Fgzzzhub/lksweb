<?php
require_once __DIR__ . '/app/core/bootstrap.php';

$routes = require __DIR__ . '/app/core/routes.php';
$route = trim((string) ($_GET['route'] ?? ''), '/');

if ($route === '') {
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $uri = trim((string) $uri, '/');

    if ($uri !== '' && $uri !== 'index.php') {
        $prefix = 'index.php/';
        if (strpos($uri, $prefix) === 0) {
            $route = substr($uri, strlen($prefix));
        } else {
            $route = $uri;
        }
    }
}

if (!isset($_GET['route']) && $route !== '') {
    $_GET['route'] = $route;
}

define('CURRENT_ROUTE', $route);

if (!isset($routes[$route])) {
    http_response_code(404);
    $pageTitle = 'Halaman Tidak Ditemukan';
    view('layouts/header', compact('pageTitle'));
    view('layouts/navbar');
    view('errors/404');
    view('layouts/footer');
    exit;
}

[$controllerClass, $method] = $routes[$route];
$controller = new $controllerClass();
$controller->$method();
