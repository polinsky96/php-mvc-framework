<?php

namespace app\core;

use app\models\UserModel;

/**
 * Class Application
 * 
 * @package app\core
 */
class Application
{   
    public static string $ROOT_DIR;
    public static Application $app;
    public static UserModel $user;
    public Database $db;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    private Controller $controller;

    public function __construct(string $rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->controller = new Controller();
        $this->session = new Session();
        
        $this->router = new Router($this->request, $this->response, $this->session);

        $this->db = new Database($config['db']);
        $this::$user = new UserModel(); 
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    public function getController(): Controller
    {
        return $this->controller;
    }

    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }
}

