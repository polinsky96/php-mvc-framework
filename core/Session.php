<?php

namespace app\core;

/**
 * Class Session
 * 
 * @package app\core
 */

class Session
{
    public function setUserSession(string $userId): void
    {
        $_SESSION['user_id'] = $userId;
    }

    public function closeUserSession(): void
    {
        unset($_SESSION['user_id']);
    }

    public function getUserId(): string
    {
        return $_SESSION['user_id'] ?? '';
    }

    public function isUser(): bool
    {
        return isset($_SESSION['user_id']);
    }
}
