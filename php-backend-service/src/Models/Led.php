<?php 
namespace App\Models;
use App\Services\Database;
use PDO;
use PDOException;

class Led {
    protected $db;
    public function __construct(){
        $this->db = Database::getInstance();

    }
    public static function all(){
        $sql = "SELECT l.*, c.ComputerName FROM [tblLed] as l 
        LEFT JOIN [tblPC] as c ON l.PCID = c.PCID";
      
        $db = Database::getInstance();
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addLed ($data){

        try {
            $sql = "INSERT INTO [tblLed] (LedName, PCID,Comport,Baudrate,SideIndex,Address,LedType,EnableLED,RowNumber) VALUES (:LedName, :PCID, :Comport, :Baudrate, :SideIndex, :Address, :LedType, :EnableLED, :RowNumber)";
            $db = Database::getInstance();
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':LedName' => $data['LedName'],
                ':PCID' => $data['PCID'],
                ':Comport' => $data['Comport'],
                ':Baudrate' => $data['Baudrate'],
                ':SideIndex' => $data['SideIndex'],
                ':Address' => $data['Address'],
                ':LedType' => $data['LedType'],
                ':EnableLED' => $data['EnableLED'],
                ':RowNumber' => $data['RowNumber'],
            ]);
        } catch (PDOException $e) {
            // Log the error or handle it as needed
            error_log("DB Insert Error: " . $e->getMessage());
            return false;
        }

    }
    public static function findLedById($id){
        try {
            $sql = "SELECT * FROM [tblLed] WHERE LedID = :id";
            $db = Database::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log the error or handle it as needed
            error_log("DB Find Error: " . $e->getMessage());
            return false;
        }
    }

    public static function updateLed($data){
        try {
            $sql = "UPDATE [tblLed] SET 
            LedName = :LedName,
            PCID = :PCID,
            Comport = :Comport,
            Baudrate = :Baudrate,
            SideIndex = :SideIndex,
            Address = :Address,
            LedType = :LedType,
            EnableLED = :EnableLED,
            RowNumber = :RowNumber
            WHERE LEDID = :LEDID";
            $db = Database::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':LedName' => $data['LedName'],
                ':PCID' => $data['PCID'],
                ':Comport' => $data['Comport'],
                ':Baudrate' => $data['Baudrate'],
                ':SideIndex' => $data['SideIndex'],
                ':Address' => $data['Address'],
                ':LedType' => $data['LedType'],
                ':EnableLED' => $data['EnableLED'],
                ':RowNumber' => $data['RowNumber'],
                ':LEDID' => $data['LEDID'],
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Log the error or handle it as needed
            error_log("DB Update Error: " . $e->getMessage());
            return false;
        }
    }

    public static function deleteLed($id){
        try {
            $sql = "DELETE FROM [tblLed] WHERE LEDID = :id";
            $db = Database::getInstance();
            $stmt = $db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            // Log the error or handle it as needed
            error_log("DB Delete Error: " . $e->getMessage());
            return false;
        }
    }
}