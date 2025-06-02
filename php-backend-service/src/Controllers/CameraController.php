<?php 
namespace App\Controllers;
use App\Models\Camera;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CameraController {

    public function index(Request $request, Response $response, $args) {
        $cameras = Camera::getAllCameras();
        $response->getBody()->write(json_encode($cameras));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(Request $request, Response $response, $args) : Response {

        $data = $request->getParsedBody();
        
       

        $result = Camera::addCamera($data);
        
        if ($result) {
            $response->getBody()->write(json_encode(['status' => 'success']));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function findCamera(Request $request, Response $response, $args) : Response {
        $cameraId = $args['id'];
        $camera = Camera::findCameraById($cameraId);
        
        if ($camera) {
            $response->getBody()->write(json_encode($camera));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
    }

    public function update(Request $request, Response $response, $args) : Response {
        $cameraId = $args['id'];
        
        $data = $request->getParsedBody();

        
        
        // Validate and sanitize input data as needed
        $data['CameraID'] = $cameraId; // Add CameraID to data for update

        $result = Camera::updateCamera($data);

    
        
        if ($result) {
            $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Camera updated successfully']));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Failed to update camera']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function delete(Request $request, Response $response, $args) : Response {
        $cameraId = $args['id'];
        
        $result = Camera::deleteCamera($cameraId);
        
        if ($result) {
            $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Camera deleted successfully']));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Failed to delete camera']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
        

    
}