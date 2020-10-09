<?php

declare(strict_types=1);

namespace App\Controller;

abstract class AbstractController
{
    public function render(string $viewName, array $data = []): void
    {
        extract($data);

        include '../views/_partials/head.phtml';
        include '../views/_partials/navbar.phtml';
        include "../views/{$viewName}.phtml";
        include '../views/_partials/footer.phtml';
    }
}
