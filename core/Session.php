<?php

namespace app\core;

/**
 * Class Session
 * 
 * @package app\core
 */

class Session
{   
    public static function start(): void
    {
        session_start();
    }

    public static function close(): void
    {
        $_SESSION = [];
        unset($_COOKIE[session_name()]);
        session_destroy();
    }

    public static function add(string $key, mixed $element): void
    {
        $_SESSION[$key] = $element;
    }

    public static function unset(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function getSessionElement(string $key): mixed
    {
        return $_SESSION["$key"] ?? '';
    }
}
