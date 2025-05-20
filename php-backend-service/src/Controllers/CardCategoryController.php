<?php 
    namespace App\Controllers;
    use App\Models\CardCate;

    
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    class CardCategoryController {
        public function index(Request $request, Response $response): Response
        {
            $cardCategories = CardCate::all();
            $response->getBody()->write(json_encode($cardCategories));
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function create(Request $request, Response $response): Response
        {
            
            // Logic to create a new card category
            // For example, you can return a form or handle the creation logic here
            $response->getBody()->write(json_encode(['message' => 'Create card category']));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

?>