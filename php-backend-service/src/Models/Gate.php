<?php 
namespace App\Models;
use App\Services\Database;
use PDO;
use PDOException;

class Gate {
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public static function all()
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM [tblGate]");    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function createGate($data){
        try {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO [tblGate] 
            (GateID, GateName, Description, Inactive) 
            VALUES (NEWID(), :GateName, :Description, :Inactive)");

        return $stmt->execute([
            ':GateName' => $data['GateName'],
            ':Description' => $data['Description'],
            
            ':Inactive' => $data['Inactive']
        ]);
    } catch (PDOException $e) {
        // Ghi log hoặc hiển thị thông báo tùy môi trường
        error_log("DB Insert Error: " . $e->getMessage());
        return false;
    }
    }

    public static function find($id){
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM [tblGate] WHERE GateID = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateGate($data){
        try {
            $db = Database::getInstance();
            $stmt = $db->prepare("UPDATE [tblGate] 
                SET GateName = :GateName, Description = :Description, Inactive = :Inactive 
                WHERE GateID = :GateID");

            return $stmt->execute([
                ':GateName' => $data['GateName'],
                ':Description' => $data['Description'],
                ':Inactive' => $data['Inactive'],
                ':GateID' => $data['GateID']
            ]);
        } catch (PDOException $e) {
            // Ghi log hoặc hiển thị thông báo tùy môi trường
            error_log("DB Update Error: " . $e->getMessage());
            return false;
        }
    }

    public static function softDelteGate($id){
        try {
            $db = Database::getInstance();
            $stmt = $db->prepare("UPDATE [tblGate] SET Inactive = 1 WHERE GateID = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            // Ghi log hoặc hiển thị thông báo tùy môi trường
            error_log("DB Soft Delete Error: " . $e->getMessage());
            return false;
        }   
    }
    

    
}