<?php

use App\Core\App;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\Dotenv\Dotenv;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Core/App.php';

session_start();

$dotEnv = new Dotenv();
$dotEnv->load(__DIR__ . '/../.env');

$paths = ['/../src/Model'];
$isDevMode = false;
$dbParams = [
    'driver'   => 'pdo_mysql',
    'user'     => $_ENV['DATABASE_USER'],
    'password' => $_ENV['DATABASE_PASSWORD'],
    'dbname'   => $_ENV['DATABASE'],
];
$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

$app = new App();
$app->loadControllerAction();