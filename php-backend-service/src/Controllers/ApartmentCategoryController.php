<?php 

namespace App\Controllers;
use App\Models\ApartmentCate;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ApartmentCategoryController {
    public function index(Request $request, Response $response): Response
    {
        $apartmentCategories = ApartmentCate::all();
        $response->getBody()->write(json_encode($apartmentCategories));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(Request $request, Response $response): Response {
        $params = (array)$request->getParsedBody();
        $CompartmentName = $params['CompartmentName'] ?? '';
        $SortOrder = $params['SortOrder'] ?? 0;

        try {
            ApartmentCate::createApartmentCategory(
                $CompartmentName,
                $SortOrder
            );
            $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Apartment category created successfully.']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Failed to create apartment category: ' . $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function findApartmentCategory(Request $request, Response $response, array $args): Response {
        $id = $args['id'] ?? '';
        
        $apartmentCategory = ApartmentCate::findApartmentCategory($id);
        if($apartmentCategory) {
            $response->getBody()->write(json_encode(['status' => 'success', 'data' => $apartmentCategory]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Apartment category not found.']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }

    public function update(Request $request, Response $response, array $args): Response {
        $id = $args['id'] ?? '';
        
        $params = (array)$request->getParsedBody();
        
        $CompartmentName = $params['CompartmentName'] ?? '';
        $SortOrder = $params['SortOrder'] ?? 0;

        try {
            ApartmentCate::updateApartmentCategory(
                $id,
                $CompartmentName,
                $SortOrder
            );
            $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Apartment category updated successfully.']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Failed to update apartment category: ' . $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            
        }

    }

    public function delete(Request $request, Response $response, array $args): Response {
        $id = $args['id'] ?? '';
        
        try {
            ApartmentCate::deleteApartmentCategory($id);
            $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Apartment category deleted successfully.']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Failed to delete apartment category: ' . $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}