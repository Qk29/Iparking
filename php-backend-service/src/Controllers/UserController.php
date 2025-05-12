<?php 
namespace App\Controllers;

use App\Services\Database;
use App\Models\User;
use App\Settings\setting;
use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface;

class UserController {

    // Cập nhật thông tin người dùng
    public function update(Request $request, Response $response, $args): Response {
        
        
    $id = $args['id'];
    $params = (array) $request->getParsedBody();
    
    $name = $params['name'] ?? null;
    $email = $params['email'] ?? null;
    $username = $params['username'] ?? null;
    $phone = $params['phone'] ?? null;
    

    if (!$name || !$email || !$username || !$phone) {
        $response->getBody()->write(json_encode(['success' => false, 'message' => 'Thiếu dữ liệu bắt buộc']));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    User::updateUser($id, $name, $email, $username, $phone);

    $response->getBody()->write(json_encode(['success' => true, 'message' => 'Cập nhật thông tin thành công']));
    return $response->withHeader('Content-Type', 'application/json');
}

    // Đổi mật khẩu người dùng
    public function changePassword(Request $request, Response $response, $args): Response {
    $id = $args['id'];
    $params = (array) $request->getParsedBody();

    $currentPassword = $params['current_password'] ?? '';
    $newPassword = $params['new_password'] ?? '';
    $confirmPassword = $params['confirm_password'] ?? '';

    if (!$currentPassword || !$newPassword || !$confirmPassword) {
        $response->getBody()->write(json_encode([
            'success' => false,
            'message' => 'Vui lòng nhập đầy đủ thông tin'
        ]));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    if ($newPassword !== $confirmPassword) {
        $response->getBody()->write(json_encode([
            'success' => false,
            'message' => 'Mật khẩu mới không khớp'
        ]));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $user = User::findPasswordById($id);

    if (!$user || $currentPassword !== $user['Password']) {
        $response->getBody()->write(json_encode([
            'success' => false,
            'message' => 'Mật khẩu hiện tại không đúng'
        ]));
        return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
    }

    User::changePassword($id, $newPassword);

    $response->getBody()->write(json_encode([
        'success' => true,
        'message' => 'Đổi mật khẩu thành công'
    ]));
    return $response->withHeader('Content-Type', 'application/json');
}

    
}