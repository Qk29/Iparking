<?php 
namespace App\Controllers;

use App\Services\Database;
use App\Models\User;
use App\Settings\setting;
use Exception;
use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface;

class UserController {


    public function index(Request $request, Response $response): Response {
        $users = User::all();
        $response->getBody()->write(json_encode($users));
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function addUserSystem(Request $request, Response $response): Response {
        $params = (array) $request->getParsedBody();
        $username = $params['username'] ?? null;
        $password = $params['password'] ?? null;
        $repassword = $params['repassword'] ?? null;
        $name = $params['name'] ?? null;
        $isAdmin = (isset($params['isAdmin']) && intval($params['isAdmin']) === 1) ? 1 : 0;

        $isActive = (isset($params['isActive']) && intval($params['isActive']) === 1) ? 1 : 0;
        $idUser = uniqid('user_');
        $isDeteled = 0;
        $roles = isset($params['roles']) ? $params['roles'] : [];
        

        if (!$username || !$password || !$repassword || !$name) {
            $response->getBody()->write(json_encode([
            'success' => false,
            'message' => 'Thiếu dữ liệu bắt buộc'
        ], JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        if ($password !== $repassword) {
             $response->getBody()->write(json_encode([
            'success' => false,
            'message' => 'Mật khẩu không khớp'
        ], JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        User::createUser($idUser,$username, $password, $name, $isAdmin, $isActive, $isDeteled);

        var_dump($roles);
        foreach($roles as $roleId){
            $idRole = uniqid('role_');
            User::assignRoleToUser($idRole,$idUser, $roleId);
        }

        $response->getBody()->write(json_encode([
        'success' => true,
        'message' => 'Tạo người dùng thành công'
        ], JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    

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

    // Xóa người dùng
    public function softDeleteUser(Request $request, Response $response, $args): Response {
        $id = $args['id'];
    try {
        User::softDelete($id); // Gọi model để cập nhật isDeleted
        
        $response->getBody()->write(json_encode([
            'success' => true,
            'message' => 'Đã xoá mềm người dùng thành công'
        ]));
        
        return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
        $response->getBody()->write(json_encode([
            'success' => false,
            'message' => 'Xoá mềm thất bại: ' . $e->getMessage()
        ]));
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
    }



    
}