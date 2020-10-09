<?php

declare(strict_types=1);

namespace App\Adapter;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class Connection
{
    public static function getEntityManager(): EntityManager
    {
        $params = [
            'driver' => DATABASE_DRIVER,
            'user' => DATABASE_USER,
            'password' => DATABASE_PASS,
            'dbname' => DATABASE_NAME,
        ];

        $paths = [
            dirname(__DIR__).'/Entity',
        ];

        $config = Setup::createAnnotationMetadataConfiguration($paths, true);

        return EntityManager::create($params, $config);
    }
}
