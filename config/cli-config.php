<?php

use App\Adapter\Connection;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once dirname(__DIR__).'/vendor/autoload.php';
require 'database.php';

$entityManager = Connection::getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);