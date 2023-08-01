<?php

use Bramus\Router\Router;
use DI\ContainerBuilder;
use Subwayminder\CrudTestTask\Controllers\IndexController;

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/../bootstrap/definitions.php');
$container = $containerBuilder->build();

$router = new Router();

$router->get('/', function () use ($container) {
    $container->call([IndexController::class, 'index']);
});

$router->run();