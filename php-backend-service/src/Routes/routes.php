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
        $systemGroup->get('/roles', \App\Controllers\RoleController::class . ':role');
        $systemGroup->put('/users/{id}/role', \App\Controllers\RoleController::class . ':updateRole');
        $systemGroup->post('/add-user', \App\Controllers\UserController::class . ':addUserSystem');
        $systemGroup->put('/users/{id}/soft-delete', \App\Controllers\UserController::class . ':softDeleteUser');
    })->add(new \App\Middleware\AuthMiddleware());


    $group->group('/category', function (RouteCollectorProxy $categoryGroup) {
        $categoryGroup->get('/card-category', \App\Controllers\CardCategoryController::class . ':index');
        $categoryGroup->get('/add-card-category', \App\Controllers\CardCategoryController::class . ':create');
    })->add(new \App\Middleware\AuthMiddleware());


    $group->group('/lane', function (RouteCollectorProxy $laneGroup) {
        $laneGroup->get('/get-all', \App\Controllers\LaneController::class . ':index'); 
    })->add(new \App\Middleware\AuthMiddleware());

    $group->group('/vehicle-group', function (RouteCollectorProxy $vehicleGroup) {
        $vehicleGroup->get('/get-all', \App\Controllers\VehicleGroupController::class . ':index'); 
    })->add(new \App\Middleware\AuthMiddleware());
});

return function (App $app) {
    $app->get('/', function ($request, $response) {
        $response->getBody()->write('Hello Your API is working!');
        return $response;
    });
};

?>