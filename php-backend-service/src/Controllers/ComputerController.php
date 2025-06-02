<?php 
namespace App\Controllers;
use App\Models\Computer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

 class ComputerController {

    public function index(Request $request, Response $response, $args) {
        $computers = Computer::all();
        $response->getBody()->write(json_encode($computers));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        // 
        // if(empty($data['ComputerName']) || empty($data['IPAddress']) || empty($data['GateID'])) {
        //     $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'ComputerName, IPAddress, and GateID are required']));
        //     return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            
        // }
        $result = Computer::createComputer($data);
        
        if ($result) {
            $response->getBody()->write(json_encode(['status' => 'success']));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error']));
            
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function findComputer(Request $request, Response $response, $args) {
        $computerID = $args['id'];
        $computer = Computer::findComputerById($computerID);
        
        if ($computer) {
            $response->getBody()->write(json_encode($computer));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
    }

    public function update(Request $request, Response $response, $args) {
        $computerID = $args['id'];
        $data = $request->getParsedBody();
        
        // Validate required fields
        if(empty($data['ComputerName']) || empty($data['IPAddress']) || empty($data['GateID'])) {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'ComputerName, IPAddress, and GateID are required']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $data['PCID'] = $computerID; // Add PCID to data for update
        
        $result = Computer::updateComputer($data);
        
        if ($result) {
            $response->getBody()->write(json_encode(['status' => 'success']));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }


 }


?>