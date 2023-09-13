<?php
namespace App\Core;

use App\Controller\ArticleController;
use DI\Container;

class App
{
    private BaseController $controller;
    private string $action;

    public function __construct(private Container $container)
    {
        $this->controller = $this->container->get(ArticleController::class);
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
        $controllerName = $urlPath[0];
        if (empty($controllerName)) {
            return $controllerName;
        } else {
            return $urlPath[0] . "Controller";
        }
    }

    private function getControllerActionName(): string
    {
        $urlPath = $this->getExplodedUrlPath();
        return empty($urlPath[1]) ? 'index' : $urlPath[1];
    }

    public function loadController(): void
    {
        $filename = __DIR__ . '/../Controller/' . ucfirst($this->getControllerName()) . '.php';
        $controllerName = $this->getControllerName();
        if (file_exists($filename)) {
            require_once $filename;
            $controllerName = ucfirst($this->getControllerName());
            $controllerName = '\\App\\Controller\\'.$controllerName;
            $this->controller = $this->container->get($controllerName);
        } elseif (empty($controllerName)) {
            $this->controller = $this->container->get(ArticleController::class);
        } else {
            $this->controller = new \App\Controller\_404Controller();
        }
    }

    //TODO: sanitize query
    private function sanitizeQuery(): array
    {
        $sanitized = [];
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return $_GET;
        } else {
            foreach ($_POST as $key => $input) {
                $input = trim($input);
                $input = htmlspecialchars($input);
                $input = filter_var($input);
                $sanitized[$key] = $input;
            }
            return $sanitized;
        }
    }

    public function loadControllerAction(): void
    {
        $this->loadController();
        $sanitizedQuery = $this->sanitizeQuery();
        if (method_exists($this->controller, $this->getControllerActionName())) {
            $this->action = $this->getControllerActionName();
        } else {
            $this->controller = new \App\Controller\_404Controller();
        }
        $this->container->call([$this->controller, $this->action], [$sanitizedQuery]);
    }
}