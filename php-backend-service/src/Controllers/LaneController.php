<?php 
    namespace App\Controllers;
    use App\Models\Lane;

    
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    class LaneController {
        public function index(Request $request, Response $response): Response
        {
            $lanes = Lane::all();
            $response->getBody()->write(json_encode($lanes));
            return $response->withHeader('Content-Type', 'application/json');
        }

    }