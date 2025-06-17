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


        // route computer
        $equipmentGroup->get('/computer-list', \App\Controllers\ComputerController::class . ':index');
        $equipmentGroup->post('/add-computer', \App\Controllers\ComputerController::class . ':create');
        $equipmentGroup->get('/find-computer/{id}', \App\Controllers\ComputerController::class . ':findComputer');
        $equipmentGroup->put('/update-computer/{id}', \App\Controllers\ComputerController::class . ':update');
        $equipmentGroup->put('/delete-computer/{id}', \App\Controllers\ComputerController::class . ':delete');

        // route camera
        $equipmentGroup->get('/camera-list', \App\Controllers\CameraController::class . ':index');
        $equipmentGroup->post('/add-camera', \App\Controllers\CameraController::class . ':create');
        $equipmentGroup->get('/find-camera/{id}', \App\Controllers\CameraController::class . ':findCamera');
        $equipmentGroup->put('/update-camera/{id}', \App\Controllers\CameraController::class . ':update');
        $equipmentGroup->put('/delete-camera/{id}', \App\Controllers\CameraController::class . ':delete');


        // route controller
        $equipmentGroup->get('/controller-list', \App\Controllers\ControllerController::class . ':index');
        $equipmentGroup->post('/add-controller', \App\Controllers\ControllerController::class . ':create');
        $equipmentGroup->get('/find-controller/{id}', \App\Controllers\ControllerController::class . ':findController');
        $equipmentGroup->put('/update-controller/{id}', \App\Controllers\ControllerController::class . ':update');
        $equipmentGroup->put('/delete-controller/{id}', \App\Controllers\ControllerController::class . ':delete');


        // route led display
        $equipmentGroup->get('/led-list', \App\Controllers\LedController::class . ':index');
        $equipmentGroup->post('/add-led', \App\Controllers\LedController::class . ':create');
        $equipmentGroup->get('/find-led/{id}', \App\Controllers\LedController::class . ':findLed');
        $equipmentGroup->put('/update-led/{id}', \App\Controllers\LedController::class . ':update');
        $equipmentGroup->put('/delete-led/{id}', \App\Controllers\LedController::class . ':delete');


        
    
    })->add(new \App\Middleware\AuthMiddleware());

    // route lane
    $group->group('/lane', function (RouteCollectorProxy $laneGroup) {
        $laneGroup->get('/get-all', \App\Controllers\LaneController::class . ':index'); 
        $laneGroup->post('/add-lane', \App\Controllers\LaneController::class . ':create');
        $laneGroup->get('/find-lane/{id}', \App\Controllers\LaneController::class . ':findLane');
        $laneGroup->put('/update-lane/{id}', \App\Controllers\LaneController::class . ':update');
        $laneGroup->delete('/delete-lane/{id}', \App\Controllers\LaneController::class . ':delete');

    })->add(new \App\Middleware\AuthMiddleware());

    // route customer-manager
    $group->group('/customer-manager', function (RouteCollectorProxy $customerManager) {
        $customerManager->get('/customer-list', \App\Controllers\CustomerManagerController::class . ':index'); 
        $customerManager->post('/add-customer', \App\Controllers\CustomerManagerController::class . ':create');
        $customerManager->get('/find-customer-manager/{id}', \App\Controllers\CustomerManagerController::class . ':find');
        $customerManager->put('/update-customer/{id}', \App\Controllers\CustomerManagerController::class . ':update');
        $customerManager->delete('/delete-customer/{id}', \App\Controllers\CustomerManagerController::class . ':delete');
    })->add(new \App\Middleware\AuthMiddleware());


    // route card-manager
    $group->group('/card-manager', function (RouteCollectorProxy $cardManager) {
        $cardManager->get('/card-list', \App\Controllers\CardManagerController::class . ':index'); 
        $cardManager->post('/add-card', \App\Controllers\CardManagerController::class . ':create');
        $cardManager->get('/find-card/{id}', \App\Controllers\CardManagerController::class . ':find');
        $cardManager->put('/update-card/{id}', \App\Controllers\CardManagerController::class . ':update');
        $cardManager->delete('/delete-card/{id}', \App\Controllers\CardManagerController::class . ':delete');
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