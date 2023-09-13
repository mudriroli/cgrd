<?php

use App\Core\App;
use DI\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\Dotenv\Dotenv;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . '/../src/Core/App.php';

session_set_cookie_params(['secure' => true, 'httponly' => true, 'samesite' => 'lax']);
session_start();

const ASSETS_PATH = '/assets/';
define("BASE_URL", ($_SERVER['REQUEST_SCHEME'] ?? 'http') . '://' . $_SERVER['HTTP_HOST']);

$container = require __DIR__ . '/../src/bootstrap.php';

$dotEnv = new Dotenv();
$dotEnv->load(__DIR__ . '/../.env');

$app = new App($container);
$app->loadControllerAction();