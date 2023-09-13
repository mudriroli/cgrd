<?php

require_once __DIR__ . '/../src/Service/ArticleService.php';
require_once __DIR__ . '/../src/Service/UserService.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

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

return [
    EntityManager::class => fn() => EntityManager::create($dbParams, $config),
];
