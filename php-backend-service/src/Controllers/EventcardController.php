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
    public function vehicleInDetail(Request $request, Response $response): Response{
        try {
            $params = (array) $request->getQueryParams();
            $timeSearch = $params['time_search'] ?? null;
            $vehicleInDetail = $this->eventCardModel->getVehiclesInDetail($timeSearch);
            $response->getBody()->write(json_encode($vehicleInDetail));
            return $response->withHeader('Content-Type', 'application/json');
            
        }catch (\Exception $e) {
            error_log("Error: " . $e->getMessage());
            $response->getBody()->write($e->getMessage());
            return $response->withStatus(500)
                    ->withHeader('Content-Type', 'text/plain');
        }
    }

    public function getCurrentVehiclesIn(Request $request, Response $response): Response {
    try {
        $params = $request->getQueryParams();

        // Chuẩn hóa giá trị truyền vào
        $filters = [
            'from_date' => isset($params['from_date']) ? date('Y-m-d H:i:s', strtotime($params['from_date'])) : null,
            'to_date' => isset($params['to_date']) ? date('Y-m-d H:i:s', strtotime($params['to_date'])) : null,
            'customer_group' => $params['customer_group'] ?? null,
            'card_group' => $params['card_group'] ?? null,
            'lane' => $params['lane'] ?? null,
            'keyword' => $params['keyword'] ?? null
        ];

        $data = $this->eventCardModel->getCurrentVehiclesIn($filters);

        $response->getBody()->write(json_encode([
            'success' => true,
            'data' => $data
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    } catch (\Exception $e) {
        $response->getBody()->write(json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]));
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
}

public function getVehicleIn(Request $request, Response $response): Response {
    try {
         $params = $request->getQueryParams();
        
        $from = $params['from_date'] ?? null;
        $to = $params['to_date'] ?? null;
        $customerGroupID = $params['customerSelect'] ?? null;
        $cardGroupID = $params['cardGroupSelect'] ?? null;
        $search = $params['search'] ?? null;

        // Chuyển đổi định dạng ngày nếu có ký tự 'T'
        if ($from && strpos($from, 'T') !== false) {
            $from = date('Y-m-d H:i:s', strtotime($from));
        }
        if ($to && strpos($to, 'T') !== false) {
            $to = date('Y-m-d H:i:s', strtotime($to));
        }

        
        // Gọi model xử lý lọc
        $offset = isset($params['offset']) ? (int)$params['offset'] : 0;
        $limit = isset($params['limit']) ? (int)$params['limit'] : 20;
        $results = $this->eventCardModel->getFilteredVehicleIn($from, $to, $customerGroupID, $cardGroupID, $search, $offset, $limit);

        $response->getBody()->write(json_encode([
            'success' => true,
            'data' => $results
        ]));
        return $response->withHeader('Content-Type', 'application/json');

        

    } catch (\Exception $e) {
        error_log("Error: " . $e->getMessage());
        $response->getBody()->write(json_encode([
            'success' => false,
            'message' => $e->getMessage(),
            'data' => []
        ]));
        return $response->withStatus(500)
                ->withHeader('Content-Type', 'application/json');
    }
}

public function getVehicleOut(Request $request, Response $response): Response {
    try {
         $params = $request->getQueryParams();
        
        $from = $params['from_date'] ?? null;
        $to = $params['to_date'] ?? null;
        $customerGroupID = $params['customerSelect'] ?? null;
        $cardGroupID = $params['cardGroupSelect'] ?? null;
        $search = $params['search'] ?? null;

        // Chuyển đổi định dạng ngày nếu có ký tự 'T'
        if ($from && strpos($from, 'T') !== false) {
            $from = date('Y-m-d H:i:s', strtotime($from));
        }
        if ($to && strpos($to, 'T') !== false) {
            $to = date('Y-m-d H:i:s', strtotime($to));
        }

        
        // Gọi model xử lý lọc
        $offset = isset($params['offset']) ? (int)$params['offset'] : 0;
        $limit = isset($params['limit']) ? (int)$params['limit'] : 20;
        $results = $this->eventCardModel->getFilteredVehicleOut($from, $to, $customerGroupID, $cardGroupID, $search, $offset, $limit);

        $response->getBody()->write(json_encode([
            'success' => true,
            'data' => $results
        ]));
        return $response->withHeader('Content-Type', 'application/json');

        

    } catch (\Exception $e) {
        error_log("Error: " . $e->getMessage());
        $response->getBody()->write(json_encode([
            'success' => false,
            'message' => $e->getMessage(),
            'data' => []
        ]));
        return $response->withStatus(500)
                ->withHeader('Content-Type', 'application/json');
    }
}

public function getVehicleFree(Request $request, Response $response): Response {
    try {
        $params = $request->getQueryParams();
        
        $from = $params['from_date'] ?? null;
        $to = $params['to_date'] ?? null;
        $cardGroupID = $params['cardGroupSelect'] ?? null;
        $search = $params['search'] ?? null;

        // Chuyển đổi định dạng ngày nếu có ký tự 'T'
        if ($from && strpos($from, 'T') !== false) {
            $from = date('Y-m-d H:i:s', strtotime($from));
        }
        if ($to && strpos($to, 'T') !== false) {
            $to = date('Y-m-d H:i:s', strtotime($to));
        }

        
        // Gọi model xử lý lọc
        $offset = isset($params['offset']) ? (int)$params['offset'] : 0;
        $limit = isset($params['limit']) ? (int)$params['limit'] : 20;
        $results = $this->eventCardModel->getFilteredVehicleFree($from, $to, $cardGroupID, $search, $offset, $limit);

        $response->getBody()->write(json_encode([
            'success' => true,
            'data' => $results
        ]));
        return $response->withHeader('Content-Type', 'application/json');

    } catch (\Exception $e) {
        error_log("Error: " . $e->getMessage());
        $response->getBody()->write(json_encode([
            'success' => false,
            'message' => $e->getMessage(),
            'data' => []
        ]));
        return $response->withStatus(500)
                ->withHeader('Content-Type', 'application/json');
    }
}

}