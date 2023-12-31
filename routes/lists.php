<?php
/**
 * @var \Bramus\Router\Router $router
 * @var \DI\Container $container
 * @var User $user
 */
use Subwayminder\CrudTestTask\Controllers\ListController;
use Subwayminder\CrudTestTask\Controllers\RecordController;
use Subwayminder\CrudTestTask\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

$router->before('GET|POST|PATCH|DELETE', 'lists.*', function () use ($user) {
    if (!$user) {
        (new JsonResponse([
            'message' => 'Auth required'
        ], Response::HTTP_UNAUTHORIZED))->send();
    }
});
$router->before('GET|POST|PATCH|DELETE', 'records.*', function () use ($user) {
    if (!$user) {
        (new JsonResponse([
            'message' => 'Auth required'
        ], Response::HTTP_UNAUTHORIZED))->send();
    }
});
// TodoList actions
$router->get('/lists', function () use ($container) {
    $container->call([ListController::class, 'index']);
});

$router->get('/lists/{id}', function (int $listId) use ($container) {
    $container->call([ListController::class, 'show'], ['id' => $listId]);
});

$router->post('/lists', function () use ($container) {
    $container->call([ListController::class, 'create']);
});

$router->patch('/lists/{id}', function (int $listId) use ($container) {
    $container->call([ListController::class, 'update'], ['id' => $listId]);
});

$router->delete('/lists/{id}', function (int $listId) use ($container) {
    $container->call([ListController::class, 'delete'], ['id' => $listId]);
});
//TodoRecords actions
$router->post('/records', function () use ($container) {
    $container->call([RecordController::class, 'create']);
});

$router->patch('/records/{id}', function (int $recordId) use ($container) {
    $container->call([RecordController::class, 'update'], ['id' => $recordId]);
});

$router->delete('/records/{id}', function (int $recordId) use ($container) {
    $container->call([RecordController::class, 'delete'], ['id' => $recordId]);
});