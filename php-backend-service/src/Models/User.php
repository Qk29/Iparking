<?php
namespace App\Models;

use App\Services\Database;
use PDO;

class User
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public static function all()
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT u.*, r.RoleName FROM [User] u LEFT JOIN [UserRole] ur ON u.Id = ur.UserId LEFT JOIN [Role] r ON ur.RoleId = r.Id WHERE u.isDeleted = 0");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function createUser($id, $username, $password, $name, $isAdmin, $isActive, $isDeteled) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO [User] (Id, Username, Password, Name, Admin, Active, isDeleted) VALUES (:id,:username, :password, :name, :admin, :active, :isDeleted)");
        $stmt->execute([
            'id' => $id,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'name' => $name,
            'admin' => $isAdmin,
            'active' => $isActive,
            'isDeleted' => $isDeteled
        ]); 
    }

    public static function assignRoleToUser($idRole,$userId, $roleId) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO UserRole (Id,UserID, RoleID) VALUES (:id,:userId, :roleId)");
        $stmt->execute([
            'id' => $idRole,
            'userId' => $userId,
            'roleId' => $roleId
        ]);
    }
    
     public static function updateUser($id, $name, $email, $username, $phone) {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE [User] SET Name = :name, Email = :email, Username = :username, Phone = :phone WHERE Id = :id");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'username' => $username,
            'phone' => $phone,
            'id' => $id
        ]);
    }


    public static function findPasswordById($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT Password FROM [User] WHERE Id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function changePassword($id, $newPassword) {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE [User] SET Password = :password WHERE Id = :id");
        $stmt->execute([
            'password' => password_hash($newPassword, PASSWORD_BCRYPT),
            'id' => $id
        ]);
    }

    public static function softDelete($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE [User] SET isDeleted = 1 WHERE Id = :id");
        $stmt->execute(['id' => $id]);
    }
}
