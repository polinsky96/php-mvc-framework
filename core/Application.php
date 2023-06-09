<?php

namespace app\core;

/**
 * Class Application
 * 
 * @package app\core
 */
class Application
{   
    public static string $ROOT_DIR;
    public static Application $app;
    public Database $db;
    public Router $router;
    public Request $request;
    public Response $response;
    private Controller $controller;

    public function __construct(string $rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->controller = new Controller();

        $this->db = new Database($config['db']);
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

