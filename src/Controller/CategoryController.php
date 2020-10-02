<?php

declare(strict_types=1);

class CategoryController extends AbstractController
{
  public function addAction(): void
  {
    $this->render('category/add');
  }

  public function listAction(): void
  {
    $this->render('category/list');
  }

  public function editAction(): void
  {
    $this->render('category/edit');
  }
}
