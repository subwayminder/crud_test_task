<?php
/**
 * @var \DI\Container $container
 */
use Bramus\Router\Router;
use Subwayminder\CrudTestTask\Controllers\AuthController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

$router = new Router();

$router->get('/', function () use ($container) {
    echo 'hi';
});
$router->post('/login', function () use ($container) {
    $container->call([AuthController::class, 'login']);
});
$router->post('/register', function () use ($container) {
    $container->call([AuthController::class, 'register']);
});
$router->set404(function () {
    (new JsonResponse([
        'message' => 'Resource not found'
    ], Response::HTTP_NOT_FOUND))->send();
});

require __DIR__ . '/lists.php';

$router->run();