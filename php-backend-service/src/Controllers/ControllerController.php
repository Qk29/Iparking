<?php 
    namespace App\Controllers;
    use App\Models\ControllerModel;

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;

    class ControllerController {
        public function index(Request $request, Response $response, $args) {
            $controllers = ControllerModel::getAllControllers();
            $response->getBody()->write(json_encode($controllers));
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function create(Request $request, Response $response, $args) {
            $data = $request->getParsedBody();

            // Validate 
            if(empty($data['ControllerName']) || empty($data['PCID']) || empty($data['CommunicationType']) || empty($data['Comport']) || empty($data['Baudrate']) || empty($data['LineTypeID']) || empty($data['Reader1Type']) || empty($data['Reader2Type']) || empty($data['Address'])) {
                $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'All fields are required']));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }

            $result = ControllerModel::addController($data);
            
            if($result) {
                $response->getBody()->write(json_encode(['status' => 'success']));
                return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
            } else {
                $response->getBody()->write(json_encode(['status' => 'error']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
        }

        public function findController(Request $request, Response $response, $args){
            $controllerId = $args['id'];
            $controller = ControllerModel::findControllerById($controllerId);

            if ($controller) {
            $response->getBody()->write(json_encode($controller));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
        }

        public function update(Request $request, Response $response, $args){
            $controllerId = $args['id'];
        $data = $request->getParsedBody();
        var_dump($data);

            // // Validate 
            // if(empty($data['ControllerName']) || empty($data['PCID']) || empty($data['CommunicationType']) || empty($data['Comport']) || empty($data['Baudrate']) || empty($data['LineTypeID']) || empty($data['Reader1Type']) || empty($data['Reader2Type']) || empty($data['Address'])) {
            //     $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'All fields are required']));
            //     return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            // }

            // Add ControllerID to data for update
            $data['ControllerID'] = $controllerId;
            $result = ControllerModel::updateController($data);

            if ($result) {
                $response->getBody()->write(json_encode(['status' => 'success']));
                return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
            } else {
                $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Failed to update controller']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
        }

        public function delete(Request $request, Response $response, $args){
            $controllerId = $args['id'];

        

        $result = ControllerModel::softDelete($controllerId);

        if ($result) {
            $response->getBody()->write(json_encode(['status' => 'success']));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Failed to delete controller']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
        }
    }


?>