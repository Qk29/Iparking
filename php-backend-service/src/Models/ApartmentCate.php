<?php 
namespace App\Models;
use App\Services\Database;
use PDO;

class ApartmentCate
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public static function all()
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM [tblCompartment]");    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function createApartmentCategory($CompartmentName, $SortOrder)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO [tblCompartment] (CompartmentID,CompartmentName) VALUES (NEWID(),:CompartmentName)");
        
        $stmt->execute([
          
            'CompartmentName' => $CompartmentName,
            
        ]);

    }

    public static function findApartmentCategory($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM [tblCompartment] WHERE CompartmentID = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateApartmentCategory($id, $CompartmentName)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE [tblCompartment] SET CompartmentName = :CompartmentName WHERE CompartmentID = :id");
        
        $stmt->execute([
            'id' => $id,
            'CompartmentName' => $CompartmentName,
            
        ]);
    }
    public static function deleteApartmentCategory($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM [tblCompartment] WHERE CompartmentID = :id");
        $stmt->execute(['id' => $id]);
    }
}