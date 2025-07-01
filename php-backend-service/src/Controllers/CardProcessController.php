<?php 

namespace App\Controllers;
use App\Models\CardProcess;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CardProcessController
{
    public function cardProcessDetail(Request $request, Response $response, $args)
    {
        $params = $request->getQueryParams();
        error_log("Full params: " . print_r($params, true));

        $action = $params['action'] ?? null;
        $from = $params['from'] ?? null;
        $to = $params['to'] ?? null;
        $customerGroupID = $params['customerSelect'] ?? null;
        $cardGroupID = $params['cardGroupSelect'] ?? null;
        $userID = $params['userSelect'] ?? null;
        $search = $params['search'] ?? null;


        error_log("Action: $action, From: $from, To: $to");

        // Gọi model xử lý lọc
        $results = CardProcess::getFilteredProcess($action, $from, $to, $cardGroupID, $customerGroupID, $userID, $search);

        $response->getBody()->write(json_encode($results));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function CardIssueSummary(Request $request, Response $response, $args){
        $params = $request->getQueryParams();
        $from = $params['from'] ?? null;
        $to = $params['to'] ?? null;

        $data = CardProcess::getCardIssueSummary($from, $to);

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');

    }
}