<?php 
    namespace App\Controllers;
    use App\Models\VehicleGroup;

    
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    class VehicleGroupController {
        public function index(Request $request, Response $response): Response
        {
            $vehicleGroups = VehicleGroup::all();
            $response->getBody()->write(json_encode($vehicleGroups));
            return $response->withHeader('Content-Type', 'application/json');
        }

    }