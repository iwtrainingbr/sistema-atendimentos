<?php

declare(strict_types=1);

namespace App\Controller;

use App\Adapter\Connection;
use App\Entity\Scheduling;
use App\Entity\User;
use App\Security\Security;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectRepository;

class IndexController extends AbstractController
{
    private EntityManager $entityManager;
    private ObjectRepository $userRepository;
    private ObjectRepository $schedulingRepository;

    public function __construct()
    {
        $this->entityManager = Connection::getEntityManager();
        $this->userRepository = $this->entityManager->getRepository(User::class);
        $this->schedulingRepository = $this->entityManager->getRepository(Scheduling::class);
    }

    public function homeAction(): void
    {
        if (Security::isLogged()) {
            header('location: /dashboard');
            return;
        }

        $this->render('home/index');
    }

    public function loginAction(): void
    {
        if (!$_POST) {
            $this->render('home/login');
            return;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userRepository->findOneBy([
            'email' => $email,
        ]);

        if (!$user) {
            header('location: /login?error=Usuário não encontrado');
            return;
        }

        if (!password_verify($password, $user->getPassword())) {
            header('location: /login?error=Senha incorreta');
            return;
        }

        $_SESSION['user_logged'] = $user->getName();
        header('location: /');
    }

    public function logoutAction()
    {
        session_destroy();
        header('location: /login');
    }

    public function dashboardAction(): void
    {
        Security::checkPermission();

        $this->render('home/dashboard', [
            'quantityUser' => count($this->userRepository->findAll()),
            'quantitySchedulingTotal' => count($this->schedulingRepository->findAll()),
            'quantitySchedulingFinished' => count($this->schedulingRepository->findBy([
                'status' => Scheduling::STATUS_FINISHED
            ])),
            'quantitySchedulingCanceled' => count($this->schedulingRepository->findBy([
                'status' => Scheduling::STATUS_CANCELED
            ])),
        ]);
    }
}
