<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;



$app->group('/api', function (RouteCollectorProxy $group) {
    $group->post('/login', \App\Controllers\AuthController::class . ':login');

    // route user
    $group->group('/users', function (RouteCollectorProxy $userGroup) {
        $userGroup->get('', \App\Controllers\UserController::class . ':index');
        $userGroup->post('', \App\Controllers\UserController::class . ':create');
        $userGroup->put('/{id}', \App\Controllers\UserController::class . ':update');
        $userGroup->delete('/{id}', \App\Controllers\UserController::class . ':delete');
        $userGroup->put('/{id}/change-password', \App\Controllers\UserController::class . ':changePassword');
    })->add(new \App\Middleware\AuthMiddleware());

    
    // route card-event
    $group->group('/system', function (RouteCollectorProxy $systemGroup) {
        $systemGroup->get('/event-cards', \App\Controllers\EventCardController::class . ':index');
        $systemGroup->get('/users', \App\Controllers\UserController::class . ':index');
        $systemGroup->get('/roles', \App\Controllers\RoleController::class . ':role');
        $systemGroup->put('/users/{id}/role', \App\Controllers\RoleController::class . ':updateRole');
        $systemGroup->post('/add-user', \App\Controllers\UserController::class . ':addUserSystem');
        $systemGroup->put('/users/{id}/soft-delete', \App\Controllers\UserController::class . ':softDeleteUser');
    })->add(new \App\Middleware\AuthMiddleware());

    
    $group->group('/category', function (RouteCollectorProxy $categoryGroup) {

        // route card-category
        $categoryGroup->get('/card-category', \App\Controllers\CardCategoryController::class . ':index');
        $categoryGroup->post('/add-card-group', \App\Controllers\CardCategoryController::class . ':create');
        $categoryGroup->put('/card-category-softdelete/{id}', \App\Controllers\CardCategoryController::class . ':delete');
        $categoryGroup->get('/find-card-category/{id}', \App\Controllers\CardCategoryController::class . ':findCardCategory');
        $categoryGroup->put('/update-card-category/{id}', \App\Controllers\CardCategoryController::class . ':update');


        // route apartment-category
        $categoryGroup->get('/apartment-category', \App\Controllers\ApartmentCategoryController::class . ':index');
        $categoryGroup->post('/add-apartment-category', \App\Controllers\ApartmentCategoryController::class . ':create');
        $categoryGroup->get('/find-apartment-category/{id}', 
        \App\Controllers\ApartmentCategoryController::class . ':findApartmentCategory');
        $categoryGroup->put('/update-apartment-category/{id}', \App\Controllers\ApartmentCategoryController::class . ':update');
        $categoryGroup->put('/apartment-category-delete/{id}',
        \App\Controllers\ApartmentCategoryController::class . ':delete');



        // route customer-group
        $categoryGroup->get('/customer-group', \App\Controllers\CustomerGroupController::class . ':index');
        $categoryGroup->post('/add-customer-group', \App\Controllers\CustomerGroupController::class . ':create');
        $categoryGroup->get('/find-customer-group/{id}', \App\Controllers\CustomerGroupController::class . ':show');
        $categoryGroup->put('/update-customer-group/{id}', \App\Controllers\CustomerGroupController::class . ':update');
        $categoryGroup->put('/customer-group-softdelete/{id}', \App\Controllers\CustomerGroupController::class . ':delete');

    })->add(new \App\Middleware\AuthMiddleware());

    // route equipment
    $group->group('/equipment', function (RouteCollectorProxy $equipmentGroup) {
        // route gate
        $equipmentGroup->get('/gate-list', \App\Controllers\GateController::class . ':index');
        $equipmentGroup->post('/add-gate', \App\Controllers\GateController::class . ':create');
        $equipmentGroup->get('/find-gate/{id}', \App\Controllers\GateController::class . ':findGate');
        $equipmentGroup->put('/update-gate/{id}', \App\Controllers\GateController::class . ':update');
        $equipmentGroup->put('/delete-gate/{id}', \App\Controllers\GateController::class . ':delete');
    
    })->add(new \App\Middleware\AuthMiddleware());

    // route lane
    $group->group('/lane', function (RouteCollectorProxy $laneGroup) {
        $laneGroup->get('/get-all', \App\Controllers\LaneController::class . ':index'); 
    })->add(new \App\Middleware\AuthMiddleware());

    // route vehicle-group
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