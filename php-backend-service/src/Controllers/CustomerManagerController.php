<?php 
    namespace App\Controllers;
    use App\Models\CustomerManager;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;

    class CustomerManagerController{
        public function index(Request $request, Response $response, $args){
            $customerManagers = CustomerManager::getAllCustomer();
            $response->getBody()->write(json_encode($customerManagers));
            return $response;
        }

        public function create(Request $request, Response $response, $args){
            $data = $request->getParsedBody();
            error_log(json_encode($data));
            // if($data['Password'] !== $data['RePassword']){
            //     $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Passwords do not match']));
            //     return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            // }
            $result = CustomerManager::addCustomer($data);
            if($result){
                $response->getBody()->write(json_encode(['status' => 'success']));
                return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
            }else{
                $response->getBody()->write(json_encode(['status' => 'error']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
        }

        public function find(Request $request, Response $response, $args){
            $id = $args['id'];
            $customerManager = CustomerManager::findCustomer($id);
            $response->getBody()->write(json_encode($customerManager));
            return $response;
        }

        public function update(Request $request, Response $response, $args){
            $id = $args['id'];
            $data = $request->getParsedBody();
            $result = CustomerManager::updateCustomer($id, $data);
            if($result){
                $response->getBody()->write(json_encode(['status' => 'success']));
                return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
            }else{
                $response->getBody()->write(json_encode(['status' => 'error']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
        }

        public function delete(Request $request, Response $response, $args){
            $id = $args['id'];
            $result = CustomerManager::deleteCustomer($id);
            if($result){
                $response->getBody()->write(json_encode(['status' => 'success']));
                return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
            }else{
                $response->getBody()->write(json_encode(['status' => 'error']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
        }
    }
?>