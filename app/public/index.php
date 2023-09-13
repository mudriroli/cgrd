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
const BOOTSTRAP_PATH = __DIR__ . '/../src/bootstrap.php';
const ENV_PATH = __DIR__ . '/../.env';
const CONFIG_PATH = __DIR__ . '/../config/config.php';
define("BASE_URL", ($_SERVER['REQUEST_SCHEME'] ?? 'http') . '://' . $_SERVER['HTTP_HOST']);

$container = require BOOTSTRAP_PATH;

$dotEnv = new Dotenv();
$dotEnv->load(ENV_PATH);

$app = new App($container);
$app->loadControllerAction();