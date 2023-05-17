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
        $this->setLayout('auth');

        $registerModel = new RegisterModel;

        if ($request->isPost()) {
            $registerModel->loadData($request->getBody());
            
            if ($registerModel->validate() && $registerModel->register()) {
                return $this->render('login'); 
            } else {
                echo "something wrong";
            }
        }
        
        return $this->render('register', [
            'model' => $registerModel
        ]); 
    }
}
