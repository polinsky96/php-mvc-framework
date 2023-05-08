<?php

namespace app\core;

/**
 * Class Router
 * 
 * @package app\core
 */
class Router
{
    public Request $request;
    public Response $response;

    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback) {
            $this->response->setStatusCode(404);
            return $this->renderView("_404");
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        if (is_array($callback)) {
            Application::$app->setController($callback[0]);
        }

        return call_user_func($callback, $this->request);
    }

    public function renderView(string $view, array $params = []): string
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent(): string
    {
        $layout = Application::$app->getController()->layout;

        ob_start();
        require_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView(string $view, array $params): string
    {
        ob_start();
        extract($params);
        require_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}
