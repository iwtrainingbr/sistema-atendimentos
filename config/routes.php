<?php

use App\Controller\CategoryController;
use App\Controller\IndexController;
use App\Controller\SchedulingController;

function mountRoute(string $controllerName, string $actionName): array
{
    return [
        'controller' => $controllerName,
        'action' => $actionName,
    ];
}

return [
    '/' => mountRoute(IndexController::class, 'homeAction'),
    '/login' => mountRoute(IndexController::class, 'loginAction'),
    '/sair' => mountRoute(IndexController::class, 'logoutAction'),
    '/dashboard' => mountRoute(IndexController::class, 'dashboardAction'),
    '/categorias' => mountRoute(CategoryController::class, 'listAction'),
    '/nova-categoria' => mountRoute(CategoryController::class, 'addAction'),
    '/categoria/excluir' => mountRoute(CategoryController::class, 'removeAction'),
    '/categoria/editar' => mountRoute(CategoryController::class, 'editAction'),
    '/categorias/pdf' => mountRoute(CategoryController::class, 'pdfAction'),
    '/agendamentos' => mountRoute(SchedulingController::class, 'listAction'),
    '/agendamentos/novo' => mountRoute(SchedulingController::class, 'addAction'),
    '/agendamentos/finalizar' => mountRoute(SchedulingController::class, 'finishAction'),
    '/agendamentos/cancelar' => mountRoute(SchedulingController::class, 'cancelAction'),
    '/agendamentos/detalhes' => mountRoute(SchedulingController::class, 'detailsAction'),
];
