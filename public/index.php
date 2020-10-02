<?php

include_once '../src/Controller/AbstractController.php';
include_once '../src/Controller/IndexController.php';
include_once '../src/Controller/CategoryController.php';

$url = $_SERVER['REQUEST_URI'];

$routes = include '../config/routes.php';

if (!isset($routes[$url])) {
 die('<h1>Página não encontrada.</h1>');
}

$parts = explode(':', $routes[$url]);

$class = $parts[0];
$method = $parts[1];

(new $class)->$method();

?>
