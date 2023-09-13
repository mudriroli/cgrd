<?php

namespace App\Core;

use App\Service\SessionService;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

abstract class BaseController
{
    protected function render($templatePath, $args = []): void
    {
        $args['assets_path'] = ASSETS_PATH;
        $loader = new FilesystemLoader('../src/View');
        $twig = new Environment($loader, [
            'debug' => true
        ]);
        $twig->addExtension(new DebugExtension());

        echo $twig->render($templatePath, $args);
    }

    protected function redirect(string $controllerName, string $action, $args = [])
    {
        $baseUrl = BASE_URL;
        $url = $baseUrl . "/$controllerName/$action";
        if (!empty($args)) {
            SessionService::setVariable('redirect_message', $args);
        }

        header("Location: $url", true,  302);
        exit;
    }
}