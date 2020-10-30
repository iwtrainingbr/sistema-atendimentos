<?php

use App\Controller\ErrorController;

ini_set('display_errors', 1);

include_once '../vendor/autoload.php';

include '../config/database.php';

session_start();

$url = explode('?', $_SERVER['REQUEST_URI'])[0];

$routes = include '../config/routes.php';

if (!isset($routes[$url])) {
 (new ErrorController)->notFoundAction();
 exit;
}

$class = $routes[$url]['controller'];
$method = $routes[$url]['action'];

(new $class)->$method();

?>
