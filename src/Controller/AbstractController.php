<?php

declare(strict_types=1);

namespace App\Controller;

use App\Security\Security;

abstract class AbstractController
{
    public function render(string $viewName, array $data = []): void
    {
        extract($data);

        include '../views/_partials/head.phtml';

        if (Security::isLogged()) {
            include '../views/_partials/navbar.phtml';
        }

        include "../views/{$viewName}.phtml";
        include '../views/_partials/footer.phtml';
    }

    public function renderFileToPdf(string $viewName, array $data = [])
    {
        extract($data);

        return include "../views/{$viewName}.phtml";
    }
}
