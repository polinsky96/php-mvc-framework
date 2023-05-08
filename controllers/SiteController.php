<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

/**
 * Class SiteController
 * 
 * @package app\controllers
 */

class SiteController extends Controller
{
    public function home(): string
    {
        $params = [
            'name' => 'JohnPolinsky Hello!'
        ];

        return $this->render('home', $params);
    }
    
    
    public function contact(): string
    {
        return $this->render('contact');
    }

    public function handleContact(Request $request): string
    {
        $body = $request->getBody();

        return "handling submitted data";
    }
}
