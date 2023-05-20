<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Session;
use app\models\LoginModel;
use app\models\RegisterModel;

/**
 * Class AuthController
 * 
 * @package app\controllers
 */

class AuthController extends Controller
{
    public function __construct()
    {
        $this->setLayout('auth');
    }

    public function login(Request $request, Session $session): string
    {
        $loginModel = new LoginModel;

        if ($request->isPost()) {
            $loginModel->loadData($request->getBody());

            if ($loginModel->validate()) {
                $userId = $loginModel->login();

                if ($userId) {
                    $session->add('user_id', $userId);

                    header("location: /");
                }
            } else {
                echo "something wrong";
            }
        }

        return $this->render('login', [
            'model' => $loginModel
        ]);
    }

    public function register(Request $request): string
    {
        $registerModel = new RegisterModel;

        if ($request->isPost()) {
            $registerModel->loadData($request->getBody());

            if ($registerModel->validate() && $registerModel->register()) {
                header("location: /");
            } else {
                echo "something wrong";
            }
        }

        return $this->render('register', [
            'model' => $registerModel
        ]);
    }
}
