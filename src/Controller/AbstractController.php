<?php

abstract class AbstractController
{
  public function render(string $viewName): void
  {
      include '../views/_partials/head.phtml';
      include '../views/_partials/navbar.phtml';
      include "../views/{$viewName}.phtml";
      include '../views/_partials/footer.phtml';
  }
}
