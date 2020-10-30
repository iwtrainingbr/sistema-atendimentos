<?php

use App\Adapter\Connection;
use App\Entity\User;

require dirname(__DIR__).'/vendor/autoload.php';
require dirname(__DIR__).'/config/database.php';

$entityManager = Connection::getEntityManager();
$repository = $entityManager->getRepository(User::class);

if ($repository->findAll()) {
    echo PHP_EOL."\033[31m===============================================".PHP_EOL;
    echo PHP_EOL."=== ERRO: Já existem usuários cadastrados no sistema".PHP_EOL;
    echo PHP_EOL."===============================================".PHP_EOL;

    return;
}

$password = password_hash('12345678', PASSWORD_ARGON2I);
$user = new User('Usuário padrão', 'admin@admin.com', $password);

$entityManager->persist($user);
$entityManager->flush();

echo PHP_EOL."===============================================".PHP_EOL;
echo PHP_EOL."=== Usuário \033[34madmin@admin.com \033[39mcriado com senha 12345678".PHP_EOL;
echo PHP_EOL."=== IMPORTANTE: Lembre de alterar a senha no primeiro login".PHP_EOL;
echo PHP_EOL."===============================================".PHP_EOL;