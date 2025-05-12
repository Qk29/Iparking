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

    public function all()
    {
        $stmt = $this->db->query("SELECT * FROM dbo.User");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
}
