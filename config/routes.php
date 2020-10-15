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
    '/categoria/excluir' => mountRoute(CategoryController::class, 'removeAction'),
    '/categoria/editar' => mountRoute(CategoryController::class, 'editAction'),
    '/categorias/pdf' => mountRoute(CategoryController::class, 'pdfAction'),
];
