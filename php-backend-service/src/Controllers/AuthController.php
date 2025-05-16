<?php
namespace App\Controllers;

use App\Services\Database;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDO;

class AuthController
{
    public function login(Request $request, Response $response): Response
    {
        $params = (array) $request->getParsedBody();
        error_log(print_r($params, true));

        $username = $params['Username'] ?? null;
        $password = $params['Password'] ?? null;
        

        if (!$username || !$password) {
            $response->getBody()->write(json_encode(['error' => 'Username and password required']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM [User] WHERE Username = :Username");
        $stmt->execute(['Username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
         error_log(print_r($user, true));
// 
        if (!$user || !password_verify($password, $user['Password']) ) {
            $response->getBody()->write(json_encode(['error' => 'Invalid credentials']));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }

        // Generate JWT token
        $payload = [
            'sub' => $user['Id'],
            'Username' => $user['Username'],
            
            'iat' => time(),
            'exp' => time() + 3600 // expires in 1 hour
        ];

        $token = JWT::encode($payload, '94cf1e086dadcd956951c4ed54e208ff372f308aded65023df6e88c816e6e7a1', 'HS256');

        $response->getBody()->write(json_encode([
            'token' => $token,
            'user' => [
                'Id' => $user['Id'],
                'Username' => $user['Username'],
                'Name' => $user['Name'],
                'Email' => $user['Email'],
                'Phone' => $user['Phone']
            ]
        ]));
        

        return $response->withHeader('Content-Type', 'application/json');

    }
}
