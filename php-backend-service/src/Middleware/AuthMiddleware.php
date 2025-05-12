<?php 
namespace App\Middleware;
use App\Services\Database;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Psr7\Response as SlimResponse;

class AuthMiddleware {
    public function __invoke(Request $request, Handler $handler): Response
    {
        // Logic kiểm tra xác thực (ví dụ: token hợp lệ không)
        // Nếu không hợp lệ:
        // $response = new SlimResponse();
        // return $response->withStatus(401)->withHeader('Content-Type', 'application/json');

        // Nếu hợp lệ:
        return $handler->handle($request);
    }
}
    