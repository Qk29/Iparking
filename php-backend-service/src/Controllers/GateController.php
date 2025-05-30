<?php 

namespace App\Controllers;
use App\Models\Gate;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class GateController {
    public function index(Request $request, Response $response): Response
    {
        $gates = Gate::all();
        $response->getBody()->write(json_encode($gates));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $result = Gate::createGate($data);

        if(!isset($data['GateName']) || empty($data['GateName'])) {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'GateName is required']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        
        if ($result) {
            $response->getBody()->write(json_encode(['status' => 'success' ]));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function findGate(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $gate = Gate::find($id);
        
        if ($gate) {
            $response->getBody()->write(json_encode($gate));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
    }
    

    public function update(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $data['GateID'] = $args['id'];
        
        if(!isset($data['GateName']) || empty($data['GateName'])) {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'GateName is required']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $result = Gate::updateGate($data);
        
        if ($result) {
            $response->getBody()->write(json_encode(['status' => 'success']));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $gate = Gate::softDelteGate($id);

        try {
            if ($gate) {
                $response->getBody()->write(json_encode(['status' => 'success']));
                return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
            } else {
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
    
}