<?php 
    namespace App\Controllers;
    use App\Models\Role;

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;

    class RoleController {
        public function role(Request $request, Response $response): Response {
        $roles = Role::allRole();
        $response->getBody()->write(json_encode($roles));
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function updateRole(Request $request, Response $response, $args): Response {
        $id = $args['id'];
        $params = (array) $request->getParsedBody();
        $roleId = $params['role_id'] ?? null;

        if (!$roleId) {
            $response->getBody()->write(json_encode(['success' => false, 'message' => 'Thiếu dữ liệu bắt buộc']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        Role::updateRole($id, $roleId);

        $response->getBody()->write(json_encode(['success' => true, 'message' => 'Cập nhật vai trò thành công']));
        return $response->withHeader('Content-Type', 'application/json');
    }
    }

    
?>