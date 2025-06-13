<?php 



namespace App\Controllers;
use App\Models\EventCard;
use Error;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class EventCardController {
    protected $eventCardModel;

    public function __construct() {
        $this->eventCardModel = new EventCard();
    }

    public function index(Request $request, Response $response): Response {
        try {
        $params = (array) $request->getQueryParams();
        $fromDate = $params['from_date'] ?? null;
        $toDate = $params['to_date'] ?? null;
        $offset = isset($params['offset']) ? (int)$params['offset'] : 0;
        $limit = isset($params['limit']) ? (int)$params['limit'] : 50;

        if (!$fromDate || !$toDate) {
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $fromDate = date('Y-m-d H:i:s', strtotime($params['from_date']));
        $toDate = date('Y-m-d H:i:s', strtotime($params['to_date']));

        // Lấy số lượng xe vào và ra trong khoảng thời gian
        $vehiclesIn = $this->eventCardModel->countVehiclesIn($fromDate, $toDate)['total'] ?? 0;
        $vehiclesOut = $this->eventCardModel->countVehiclesOut($fromDate, $toDate)['total'] ?? 0;

        $vehiclesInList = $this->eventCardModel->getVehiclesIn($fromDate, $toDate, $offset, $limit);
        $vehiclesOutList = $this->eventCardModel->getVehiclesOut($fromDate, $toDate, $offset, $limit);
       

       $payload = json_encode([
            'success' => true,
            'data' => [
                'vehicles_in' => $vehiclesIn,
                'vehicles_out' => $vehiclesOut,
                'vehicles_in_list' => $vehiclesInList,
                'vehicles_out_list' => $vehiclesOutList,
                
            ]
        ]);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            error_log("Error: " . $e->getMessage());
            $response->getBody()->write($e->getMessage());
            return $response->withStatus(500)
                    ->withHeader('Content-Type', 'text/plain');
        }
        
    }
}