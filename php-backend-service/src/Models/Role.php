<?php
namespace App\Models;

use App\Services\Database;
use PDO;


class Role
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public static function allRole(){
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM [Role]");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateRole($id, $roleId){
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE [UserRole] SET RoleId = :roleId WHERE UserId = :id");
        $stmt->execute([
            'roleId' => $roleId,
            'id' => $id
        ]);

    }

}
?>