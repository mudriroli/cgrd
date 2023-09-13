<?php

namespace App\Service;

class SessionService
{
    public static function getVariable(string $key): array|bool
    {
        $sessionVariable = [];
        if (isset($_SESSION[$key])) {
            $sessionVariable = $_SESSION[$key];
        }
        return empty($sessionVariable) ? false : $sessionVariable;
    }

    public static function setVariable($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function unsetVariable(string $key): void
    {
        if (isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }
    }
}