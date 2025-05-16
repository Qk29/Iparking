<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;



$app->group('/api', function (RouteCollectorProxy $group) {
    $group->post('/login', \App\Controllers\AuthController::class . ':login');

    $group->group('/users', function (RouteCollectorProxy $userGroup) {
        $userGroup->get('', \App\Controllers\UserController::class . ':index');
        $userGroup->post('', \App\Controllers\UserController::class . ':create');
        $userGroup->put('/{id}', \App\Controllers\UserController::class . ':update');
        $userGroup->delete('/{id}', \App\Controllers\UserController::class . ':delete');
        $userGroup->put('/{id}/change-password', \App\Controllers\UserController::class . ':changePassword');
    })->add(new \App\Middleware\AuthMiddleware());

    $group->group('/system', function (RouteCollectorProxy $systemGroup) {
        $systemGroup->get('/event-cards', \App\Controllers\EventCardController::class . ':index');

        $systemGroup->get('/users', \App\Controllers\UserController::class . ':index');

        $systemGroup->get('/roles', \App\Controllers\UserController::class . ':role');

        $systemGroup->put('/users/{id}/role', \App\Controllers\UserController::class . ':updateRole');
        
    })->add(new \App\Middleware\AuthMiddleware());
});

return function (App $app) {
    $app->get('/', function ($request, $response) {
        $response->getBody()->write('Hello Your API is working!');
        return $response;
    });
};

?>