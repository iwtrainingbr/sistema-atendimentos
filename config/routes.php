<?php

use App\Controller\CategoryController;
use App\Controller\IndexController;

function mountRoute(string $controllerName, string $actionName): array
{
    return [
        'controller' => $controllerName,
        'action' => $actionName,
    ];
}

return [
  '/' => mountRoute(IndexController::class, 'homeAction'),
  '/categorias' => mountRoute(CategoryController::class, 'listAction'),
  '/nova-categoria' => mountRoute(CategoryController::class, 'addAction'),
];
