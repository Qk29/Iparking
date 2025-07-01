<?php 
namespace App\Controllers;
use App\Models\CardManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\helpers\CardProcessLogger;

class CardManagerController {
    
    public function index(Request $request, Response $response, $args) {
        $cardList = CardManager::getAllCard(); 
        $response->getBody()->write(json_encode($cardList));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Add other methods for creating, updating, and deleting customers as needed
    public function create(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        // error_log(json_encode($data));
        $result = CardManager::addCard($data);
        if ($result) {
            // Log the action
            $cardId = $result ?? null;
            if ($cardId) {
                CardProcessLogger::logAction($cardId, 'ADD', $data['UserID'] ?? null, 'Card created successfully');
            }
            $response->getBody()->write(json_encode(['status' => 'success']));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function find(Request $request, Response $response, $args) {
        $id = $args['id'];
        $card = CardManager::findCard($id);
        if ($card) {
            $response->getBody()->write(json_encode($card));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Card not found']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
    }

    public function update(Request $request, Response $response, $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $result = CardManager::updateCard($id, $data);
        if ($result) {
            $response->getBody()->write(json_encode(['status' => 'success']));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
    public function delete(Request $request, Response $response, $args) {
        $id = $args['id'];
        // lấy thông tin thẻ trước khi xoá
        $cardInfo = CardManager::findCard($id);
        $result = CardManager::deleteCard($id);
        if ($result) {
            // Log the action
            CardProcessLogger::logAction($id, 'DELETE', $request->getAttribute('userId'), 'Card deleted successfully',$cardInfo);

            $response->getBody()->write(json_encode(['status' => 'success']));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Failed to delete card']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
    public function bulkUpdateLock(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $result = CardManager::bulkUpdateLockModel($data);
        if ($result) {
            // Log the action for each card
            foreach ($data['cardids'] as $cardId) {
                error_log("[CARD PROCESS LOG] About to call logAction for cardId=$cardId, action=LOCK");
                CardProcessLogger::logAction($cardId, 'LOCK', $data['UserID'] ?? null, 'Card locked successfully');
            }
            $response->getBody()->write(json_encode(['status' => 'success']));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function bulkUpdateUnlock(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $result = CardManager::bulkUpdateUnlockModel($data);
        if ($result) {
            // Log the action for each card
            foreach ($data['cardids'] as $cardId) {
                error_log("[CARD PROCESS LOG] About to call logAction for cardId=$cardId, action=UNLOCK");
                CardProcessLogger::logAction($cardId, 'UNLOCK', $data['UserID'] ?? null, 'Card unlocked successfully');
            }
            $response->getBody()->write(json_encode(['status' => 'success']));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function renewCards(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        
        $result = CardManager::renewCardsModel($data);
        if ($result) {
            // Log the action for each card
            foreach ($data['cardids'] as $cardId) {
                CardProcessLogger::logAction($cardId, 'RENEW', $data['UserID'] ?? null, 'Card renewed successfully');
            }
            $response->getBody()->write(json_encode(['status' => 'success']));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function activateCards(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        
        error_log("[DEBUG] activateCards received data: " . json_encode($data));
        $result = CardManager::activateCardsModel($data);
       
        if ($result) {
           
            // Log the action for each card
            foreach ($data['cardids'] as $cardId) {
                
                CardProcessLogger::logAction($cardId, 'ACTIVATE', $data['UserID'] ?? null, 'Card activated successfully');
               
            }
            $response->getBody()->write(json_encode(['status' => 'success']));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}

?>