<?php 
    namespace App\Controllers;
    use App\Models\Led;

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;

    class LedController {
        public function index(Request $request, Response $response){
            $leds = Led::all();
            $response->getBody()->write(json_encode($leds));
            return $response->withHeader('Content-Type', 'application/json');
        }

      

        public function create(Request $request, Response $response, $args) : Response {
            $data = $request->getParsedBody();
            
            
            $result = Led::addLed($data);
            
            if ($result) {
                $response->getBody()->write(json_encode(['status' => 'success']));
                return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
            } else {
                $response->getBody()->write(json_encode(['status' => 'error']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
        }
        public function findLed(Request $request, Response $response, $args) : Response {
            $id = $args['id'];
            $led = Led::findLedById($id);
            $response->getBody()->write(json_encode($led));
            return $response->withHeader('Content-Type', 'application/json');

        }

        public function update(Request $request, Response $response, $args) : Response {
            $ledId = $args['id'];
            
            $data = $request->getParsedBody();
            var_dump($data);
            $data['LEDID'] = $ledId;
            $result = Led::updateLed($data);
            if ($result) {
                $response->getBody()->write(json_encode(['status' => 'success']));
                return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
            } else {
                
                $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Không có thay đổi hoặc lỗi DB']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }

        }

        public function delete(Request $request, Response $response, $args) : Response {
            $id = $args['id'];
            $result = Led::deleteLed($id);
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