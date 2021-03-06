<?php

declare(strict_types=1);

namespace App\Controller;

use App\Adapter\Connection;
use App\Entity\Category;
use App\Security\Security;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectRepository;
use Dompdf\Dompdf;
use Dompdf\Options;

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
        Security::checkPermission();

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
        Security::checkPermission();

        $this->render('category/list', [
            'categories' => $this->repository->findAll(),
        ]);
    }

    public function editAction(): void
    {
        Security::checkPermission();

        $category = $this->repository->find($_GET['id']);

        if ($_POST) {
            $category->setName($_POST['name']);
            $category->setDescription($_POST['description']);

            $this->entityManager->persist($category);
            $this->entityManager->flush();

            header('location: /categorias');
        }

        $this->render('category/edit', [
            'category' => $category,
        ]);
    }

    public function removeAction(): void
    {
        Security::checkPermission();

        $id = $_GET['id'];
        $category = $this->repository->find($id);

        $this->entityManager->remove($category);
        $this->entityManager->flush();

        header('location: /categorias');
    }

    public function pdfAction(): void
    {
        Security::checkPermission();

        $today = new \DateTime();

        $file = $this->renderFileToPdf('category/pdf', [
            'categories' => $this->repository->findAll(),
        ]);

        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($file);
        $dompdf->setOptions($options);
        $dompdf->render();
        $dompdf->stream('Relatorio-Categorias-'.$today->format('dmY').'.pdf', [
            'Attachment' => false,
        ]);
    }
}
