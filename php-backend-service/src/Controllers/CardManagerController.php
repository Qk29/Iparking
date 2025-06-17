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
}

?>