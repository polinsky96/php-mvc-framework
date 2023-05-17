<?php

namespace app\core;

/**
 * Class Migration
 * 
 * @package app\core
 */

class Session
{
    public function setUserSession(string $userId, string $username): void
    {
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $userId;
    }

    public function closeUserSession(): void
    {
        unset($_SESSION['username']);
        unset($_SESSION['user_id']);
    }

    public function getUsername(): string
    {
        return $_SESSION['username'] ?? '';
    }

    public function getUserId(): string
    {
        return $_SESSION['user_id'] ?? '';
    }

    public function isUser(): bool
    {
        return isset($_SESSION['username']);
    }
}