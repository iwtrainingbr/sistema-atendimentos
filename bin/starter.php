<?php

require dirname(__DIR__).'/config/database.php';

$db_user = DATABASE_USER;
$db_pass = DATABASE_PASS;
$db_name = DATABASE_NAME;

echo PHP_EOL."=== Instalando Pacotes com o Composer.".PHP_EOL;
shell_exec("composer install");

echo PHP_EOL."=== Criando Banco de Dados.".PHP_EOL;
shell_exec("mysql -u {$db_user} -p{$db_pass} -e 'CREATE DATABASE {$db_name}'");

echo PHP_EOL."=== Gerando as tabelas do Banco de Dados.".PHP_EOL;
shell_exec("php vendor/doctrine/orm/bin/doctrine orm:schema-tool:update --force");

echo PHP_EOL."=== Gerando o usuário padrão do sistema.".PHP_EOL;
shell_exec("php bin/generate-user.php");


