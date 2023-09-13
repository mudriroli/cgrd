<?php

namespace App;

require __DIR__ . '/../vendor/autoload.php';

use App\Service\ArticleService;
use App\Service\UserService;
use DI\Container;
use DI\ContainerBuilder;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\QueryBuilder;
use function DI\create;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../config/config.php');
$container = $containerBuilder->build();

return $container;
