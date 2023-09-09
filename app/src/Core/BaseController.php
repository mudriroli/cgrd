<?php

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class BaseController
{
    protected function render($templatePath, $args = []): void
    {
        $loader = new FilesystemLoader('../src/View');
        $twig = new Environment($loader);
        echo $twig->render($templatePath, $args);
    }
}