<?php

declare(strict_types=1);

class IndexController extends AbstractController
{
  public function homeAction(): void
  {  
    $this->render('home/index');
  }
}
