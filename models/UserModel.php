<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
use app\core\Session;
use PDO;

/**
 * Class UserModel
 * 
 * @package app\models
 */
class UserModel extends Model
{
    private string $userId = '';
    private string $firstname = '';
    private string $lastname = '';
    private string $email = '';

    private bool $isUser = false;

    public function __construct()
    {
        parent::__construct();

        $this->userId = Session::getSessionElement('user_id');

        if ($this->userId !== '') {
            $user = $this->loadUserData($this->userId);

            if ($user) {
                $this->firstname = $user['firstname'] ?? '';
                $this->lastname = $user['lastname'] ?? '';
                $this->email = $user['email'] ?? '';
    
                $this->isUser = true;
            }
        }
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isUser(): bool
    {
        return $this->isUser;
    }

    private function loadUserData(string $id): array | bool
    {
        $statement = $this->db->pdo->prepare("SELECT id, firstname, lastname, email FROM users WHERE id = '$id'");
        $statement->execute();
        return $statement->fetch();
    }

    public function rules(): array
    {
        return [];
    }
}
