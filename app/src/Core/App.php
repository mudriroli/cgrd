<?php
namespace App\Core;

class App
{
    private BaseController $controller;
    private string $action;

    public function __construct()
    {
        $this->controller = new \App\Controller\Home();
        $this->action = 'index';
    }

    private function getExplodedUrlPath(): array
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = ltrim($url, '/');
        $url = parse_url($url);

        return explode('/', $url['path']);
    }

    private function getQueryParams()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = ltrim($url, '/');
        $url = parse_url($url,PHP_URL_QUERY);
        parse_str($url, $queryParams);

        return $queryParams;
    }

    private function getControllerName(): string
    {
        $urlPath = $this->getExplodedUrlPath();

        return $urlPath[0];
    }

    private function getControllerActionName(): string
    {
        $urlPath = $this->getExplodedUrlPath();

        return $urlPath[1] ?? 'index';
    }

    public function loadController(): void
    {
        $filename = __DIR__ . '/../Controller/' . ucfirst($this->getControllerName()) . '.php';
        $controllerName = $this->getControllerName();
        if (file_exists($filename)) {
            require_once $filename;
            $controllerName = ucfirst($this->getControllerName());
            $controllerName = '\\App\\Controller\\'.$controllerName;
            $this->controller = new $controllerName;
        } elseif (empty($controllerName)) {
            $this->controller = new \App\Controller\Home();
        } else {
            $this->controller = new \App\Controller\_404();
        }
    }

    //TODO: sanitize query
    private function sanitizeQuery(): array
    {
        return $_GET;
    }

    public function loadControllerAction(): void
    {
        $this->loadController();

        $sanitizedQuery = $this->sanitizeQuery();
        if (method_exists($this->controller, $this->getControllerActionName())) {
            $this->action = $this->getControllerActionName();
        } else {
            $this->controller = new \App\Controller\_404();
        }
        call_user_func_array([$this->controller, $this->action], [$sanitizedQuery]);
    }
}