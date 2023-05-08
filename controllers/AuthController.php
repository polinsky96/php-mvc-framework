<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\RegisterModel;

/**
 * Class AuthController
 * 
 * @package app\controllers
 */

class AuthController extends Controller
{
    public function login(): string
    {
        $this->setLayout('auth');

        return $this->render('login');
    }

    public function register(Request $request): string
    {
        if ($request->isPost()) {
            $registerModel = new RegisterModel;
            $registerModel->loadData($request->getBody());
            
            if ($registerModel->validate() && $registerModel->register()) {
                return "success";
            }

            echo "<pre>";
            var_dump($registerModel->errors);
            echo "</pre>";
            exit;

            return $this->render('register', [
                'model' => $registerModel
            ]);
        }
        
        return $this->render('register');
    }
}
