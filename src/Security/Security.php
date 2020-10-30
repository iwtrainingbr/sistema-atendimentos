<?php

declare(strict_types=1);

namespace App\Security;

class Security
{
    public static function checkPermission(): void
    {
        if (!self::isLogged()) {
            header('location: /?error=Sem permissão pra ver esse conteúdo');
            exit;
        }
    }

    public static function isLogged(): bool
    {
        return isset($_SESSION['user_logged']);
    }

    public static function getUserLogged(): string
    {
        return $_SESSION['user_logged'];
    }
}
