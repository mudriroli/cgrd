<?php

require_once __DIR__ . '/../src/Service/ArticleService.php';
require_once __DIR__ . '/../src/Service/GetUserService.php';

use App\Service\ArticleService;
use App\Service\GetUserService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use function DI\create;

$paths = ['/../src/Model'];
$isDevMode = false;
$dbParams = [
    'driver'   => 'pdo_mysql',
    'user'     => $_ENV['DATABASE_USER'],
    'password' => $_ENV['DATABASE_PASSWORD'],
    'dbname'   => $_ENV['DATABASE'],
    'host'     => 'mysql'
];

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
//$connection = DriverManager::getConnection($dbParams, $config);
//$entityManager = new EntityManager($connection, $config);

return [
    EntityManager::class => fn() => EntityManager::create($dbParams, $config),
];
