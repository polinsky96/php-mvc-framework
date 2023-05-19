<?php

namespace app\models;

use app\core\Model;

/**
 * Class LoginModel
 * 
 * @package app\models
 */
class LoginModel extends Model
{
    public string $email = '';
    public string $password = '';

    public function login():bool
    {
        try {
            $values = [
                ':email' => $this->email,
                ':password' => $this->password
            ];

            $statement = $this->db->pdo->query('SELECT ');

            return true;
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
