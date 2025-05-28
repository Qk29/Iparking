<?php 
namespace App\Models;
use App\Services\Database;
use PDO;

class CustomerCate {
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public static function all()
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM [tblCustomerGroup] WHERE Inactive = 0 ORDER BY Ordering ASC");    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function createCustomerGroup($data){
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO [tblCustomerGroup] (CustomerGroupID,CustomerGroupName, ParentId, Ordering, QuotaCar, QuotaBike, QuotaMotor) VALUES (NEWID(),:CustomerGroupName, :ParentId, :Ordering, :QuotaCar, :QuotaBike, :QuotaMotor)");
        
        return $stmt->execute([
            ':CustomerGroupName' => $data['CustomerGroupName'],
            ':ParentId' => $data['ParentId'],
            ':Ordering' => $data['Ordering'],
            ':QuotaCar' => $data['QuotaCar'],
            ':QuotaBike' => $data['QuotaBike'],
            ':QuotaMotor' => $data['QuotaMotor']
        ]);
    }

    public static function findCustomerGroup($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM [tblCustomerGroup] WHERE CustomerGroupID = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateCustomerGroup($id, $data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE [tblCustomerGroup] SET CustomerGroupName = :CustomerGroupName, ParentId = :ParentId, Ordering = :Ordering, QuotaCar = :QuotaCar, QuotaBike = :QuotaBike, QuotaMotor = :QuotaMotor WHERE CustomerGroupID = :id");
        
        return $stmt->execute([
            ':CustomerGroupName' => $data['CustomerGroupName'],
            ':ParentId' => $data['ParentId'],
            ':Ordering' => $data['Ordering'],
            ':QuotaCar' => $data['QuotaCar'],
            ':QuotaBike' => $data['QuotaBike'],
            ':QuotaMotor' => $data['QuotaMotor'],
            ':id' => $id
        ]);
    }

    public static function deleteCustomerGroup($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE [tblCustomerGroup] SET Inactive = 1 WHERE CustomerGroupID = :id");
        return $stmt->execute([':id' => $id]);
    }

    
}