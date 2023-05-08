<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

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
            return "handle sub data";
        }

        return $this->render('register');
    }
}
