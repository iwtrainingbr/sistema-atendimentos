<?php

declare(strict_types=1);

namespace App\Controller;

use App\Adapter\Connection;
use App\Entity\Category;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectRepository;

class CategoryController extends AbstractController
{
    private EntityManager $entityManager;
    private ObjectRepository $repository;

    public function __construct()
    {
        $this->entityManager = Connection::getEntityManager();
        $this->repository = $this->entityManager->getRepository(Category::class);
    }

    public function addAction(): void
    {
        if ($_POST) {
            $category = new Category();
            $category->setName($_POST['name']);
            $category->setDescription($_POST['description']);

            $this->entityManager->persist($category);
            $this->entityManager->flush();

            header('location: /categorias');
            return;
        }

        $this->render('category/add');
    }

    public function listAction(): void
    {
        $this->render('category/list', [
            'categories' => $this->repository->findAll(),
        ]);
    }

  public function editAction(): void
  {
    $this->render('category/edit');
  }
}
