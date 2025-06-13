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

        public function create(Request $request, Response $response, $args) : Response {
            $data = $request->getParsedBody();

            $result = Lane::addLane($data);
            
            if ($result) {
                $response->getBody()->write(json_encode(['status' => 'success']));
                return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
            } else {
                $response->getBody()->write(json_encode(['status' => 'error']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
        }

        public function findLane(Request $request, Response $response, $args) : Response {
            $id = $args['id'];
            $lane = Lane::findLaneById($id);
            $response->getBody()->write(json_encode($lane));
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function update(Request $request, Response $response, $args) : Response {
            $id = $args['id'];
            $data = $request->getParsedBody();
            $result = Lane::updateLane($id, $data);
            if ($result) {
                $response->getBody()->write(json_encode(['status' => 'success']));
                return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
            } else {
                $response->getBody()->write(json_encode(['status' => 'error']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
        }

        public function delete(Request $request, Response $response, $args) : Response {
            try {
                $id = $args['id'];
            error_log("Deleting lane with ID: $id"); 
            $result = Lane::DeleteLane($id);
            if ($result) {
                $response->getBody()->write(json_encode(['status' => 'success']));
                return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
            } else {
                $response->getBody()->write(json_encode(['status' => 'error']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
            } catch (\Throwable $e) {
                error_log("EXCEPTION: " . $e->getMessage());
        $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }   
        }

    }