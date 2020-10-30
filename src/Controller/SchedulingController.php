<?php

declare(strict_types=1);

namespace App\Controller;

use App\Adapter\Connection;
use App\Entity\Category;
use App\Entity\Scheduling;
use App\Security\Security;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectRepository;

class SchedulingController extends AbstractController
{
    private EntityManager $entityManager;
    private ObjectRepository $categoryRepository;
    private ObjectRepository $schedulingRepository;

    public function __construct()
    {
        $this->entityManager = Connection::getEntityManager();
        $this->categoryRepository = $this->entityManager->getRepository(Category::class);
        $this->schedulingRepository = $this->entityManager->getRepository(Scheduling::class);
    }

    public function finishAction(): void
    {
        $id = $_GET['id'];

        $scheduling = $this->schedulingRepository->find($id);
        $scheduling->setStatus(Scheduling::STATUS_FINISHED);

        $this->entityManager->persist($scheduling);
        $this->entityManager->flush();

        header('location: /agendamentos');
    }

    public function cancelAction(): void
    {
        $id = $_GET['id'];

        $scheduling = $this->schedulingRepository->find($id);
        $scheduling->setStatus(Scheduling::STATUS_CANCELED);

        $this->entityManager->persist($scheduling);
        $this->entityManager->flush();

        header('location: /agendamentos');
    }

    public function listAction(): void
    {
        Security::checkPermission();

        $this->render('scheduling/list', [
            'scheduling' => $this->schedulingRepository->findAll(),
        ]);
    }

    public function addAction(): void
    {
        if ($_POST) {
            /** @var Category $category */
            $category = $this->categoryRepository->find($_POST['category']);

            $datetime = $_POST['date'].$_POST['time'];

            $scheduling = new Scheduling();
            $scheduling->setDescription($_POST['description']);
            $scheduling->setCustomer($_POST['name']);
            $scheduling->setCategory($category);
            $scheduling->setDatetime(
                \DateTime::createFromFormat('d/m/YH:i', $datetime)
            );

            $this->entityManager->persist($scheduling);
            $this->entityManager->flush();

            if (!Security::isLogged()) {
                $number = $scheduling->getId().'-'.$scheduling->getCreatedAt()->format('Ymd');
                header('location: /agendamentos/detalhes?number='.$number);
                return;
            }

            header('location: /agendamentos');
            return;
        }

        $times = [
            '08:00',
            '08:30',
            '09:00',
            '09:30',
            '10:00',
            '10:30',
        ];

        $today = new \DateTime();
        $dates = [
            $today->modify('+1 day')->format('d/m/Y'),
            $today->modify('+2 day')->format('d/m/Y'),
            $today->modify('+3 day')->format('d/m/Y'),
            $today->modify('+4 day')->format('d/m/Y'),
            $today->modify('+5 day')->format('d/m/Y'),
        ];

        $this->render('scheduling/add', [
            'categories' => $this->categoryRepository->findAll(),
            'times' => $times,
            'dates' => $dates,
        ]);
    }

    public function detailsAction(): void
    {
        if (!isset($_GET['number'])) {
            $this->render('scheduling/details');
            return;
        }

        $number = explode('-', $_GET['number']);

        $details = $this->schedulingRepository->find($number[0]);

        if ($details->getCreatedAt()->format('Ymd') !== $number[1]) {
            header('location: /agendamentos/detalhes?error=Agendamento não encontrado');
            return;
        }

        $this->render('scheduling/details', [
            'details' => $details,
        ]);
    }
}
