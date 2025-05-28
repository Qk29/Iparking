<?php 

namespace App\Controllers;
use App\Models\CustomerCate;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CustomerGroupController {
    public function index(Request $request, Response $response): Response
    {
        $customerGroups = CustomerCate::all(); // Assuming you have a model for customer groups
        $response->getBody()->write(json_encode($customerGroups));
        return $response->withHeader('Content-Type', 'application/json');
    }
    public function create(Request $request, Response $response): Response{
        $params = $request->getParsedBody();
        $data = [
            'CustomerGroupName' => $params['CustomerGroupName'] ?? '',
            'ParentId' => $params['ParentId'] ?? 0,
            'Ordering' => $params['Ordering'] ?? 0,
            'SortOrder' => $params['SortOrder'] ?? 0,
            'QuotaCar' => $params['QuotaCar'] ?? 0,
            'QuotaBike' => $params['QuotaBike'] ?? 0,
            'QuotaMotor' => $params['QuotaMotor'] ?? 0,
            'IsCompany' => $params['IsCompany'] ?? 0,
            'Inactive' => isset($params['Inactive']) ? 0 : 1
        ];
        try {
            $result = CustomerCate::createCustomerGroup($data);
            if($result){
                $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Customer group created successfully.']));
                
            }
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Failed to create customer group: ' . $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }

    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $customerGroup = CustomerCate::findCustomerGroup($id);
        if ($customerGroup) {
            $response->getBody()->write(json_encode($customerGroup));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Customer group not found.']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $params = $request->getParsedBody();
        $data = [
            'CustomerGroupName' => $params['CustomerGroupName'] ?? '',
            'ParentId' => $params['ParentId'] ?? 0,
            'Ordering' => $params['Ordering'] ?? 0,
            'SortOrder' => $params['SortOrder'] ?? 0,
            'QuotaCar' => $params['QuotaCar'] ?? 0,
            'QuotaBike' => $params['QuotaBike'] ?? 0,
            'QuotaMotor' => $params['QuotaMotor'] ?? 0,
            'IsCompany' => $params['IsCompany'] ?? 0,
            'Inactive' => isset($params['Inactive']) ? 0 : 1
        ];
        try {
            $result = CustomerCate::updateCustomerGroup($id, $data);
            if ($result) {
                $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Customer group updated successfully.']));
                return $response->withHeader('Content-Type', 'application/json');
            } else {
                throw new \Exception('Failed to update customer group.');
            }
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Failed to update customer group: ' . $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        try {
            $result = CustomerCate::deleteCustomerGroup($id);
            if ($result) {
                $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Customer group deleted successfully.']));
                return $response->withHeader('Content-Type', 'application/json');
            } else {
                throw new \Exception('Failed to delete customer group.');
            }
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Failed to delete customer group: ' . $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}

?>