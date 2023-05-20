<?php

namespace app\models;

use app\core\Model;
use PDO;

/**
 * Class LoginModel
 * 
 * @package app\models
 */
class LoginModel extends Model
{
    public string $email = '';
    public string $password = '';

    public function login(): string | bool
    {
        try {
            $values = [
                ':email' => $this->email,
                ':password' => $this->password
            ];

            $statement = $this->db->pdo->prepare("SELECT * FROM users WHERE email = '$this->email'");
            $statement->execute();

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($this->password, $user['password'])) {
                return $user['id'];
            } else {
                return false;
            }
        } catch (\PDOException $th) {
            return false;
        }
    }

    public function rules(): array
    {
        return [
            'email' => [
                self::RULE_REQUIRED,
                self::RULE_EMAIL
            ],
            'password' => [
                self::RULE_REQUIRED,
            ],
        ];
    }
}
