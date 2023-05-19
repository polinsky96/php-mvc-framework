<?php

namespace app\models;

use app\core\Model;

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

    public function __construct(string $userId, string $firstname, string $lastname, string $email) {
        $this->userId = $userId;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
    }

    public function rules(): array {
        return [];
    }
}
