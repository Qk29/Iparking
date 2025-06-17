<?php 
namespace App\Controllers;
use App\Models\CardManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CardManagerController {
    
    public function index(Request $request, Response $response, $args) {
        $cardList = CardManager::getAllCard(); 
        $response->getBody()->write(json_encode($cardList));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Add other methods for creating, updating, and deleting customers as needed
    public function create(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        error_log(json_encode($data));
        $result = CardManager::addCard($data);
        if ($result) {
            $response->getBody()->write(json_encode(['status' => 'success']));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}

?>