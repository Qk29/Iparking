<?php 
namespace App\Models;
use App\Services\Database;
use PDO;
use PDOException;

class Computer {
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    public static function all()
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT c.*, g.GateName FROM [tblPC] as c
                            LEFT JOIN [tblGate] as g ON c.GateID = g.GateID
                           ");    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function createComputer($data){
        try{
            $db = Database::getInstance();
            $sql = 'INSERT INTO [tblPC] 
                    (PCID, ComputerName, Description, IPAddress, PicPathIn, PicPathOut, VideoPath, Inactive, GateID,VideoDays) 
                    VALUES (NEWID(), :ComputerName, :Description, :IPAddress, :PicPathIn, :PicPathOut, :VideoPath, :Inactive, :GateID, :VideoDays)';
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':ComputerName' => $data['ComputerName'],
                ':Description' => $data['Description'],
                ':IPAddress' => $data['IPAddress'],
                ':PicPathIn' => $data['PicPathIn'],
                ':PicPathOut' => $data['PicPathOut'],
                ':VideoPath' => $data['VideoPath'],
                ':Inactive' => isset($data['Inactive']) ? 0 : 1,
                ':GateID' => $data['GateID'],
                ':VideoDays' => $data['VideoDays'] ?? 0
            ]);
        }catch (PDOException $e) {
            // Ghi log hoặc hiển thị thông báo tùy môi trường
            error_log("DB Insert Error: " . $e->getMessage());
            return false;
        }
    }

    public static function findComputerById($id) {
        try {
            $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM [tblPC] WHERE PCID = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Ghi log hoặc hiển thị thông báo tùy môi trường
            error_log("DB Select Error: " . $e->getMessage());
            return false;
            
        }
    }

    public static function updateComputer($data) {
        try {
            $db = Database::getInstance();
            $sql = 'UPDATE [tblPC] SET 
                    ComputerName = :ComputerName, 
                    Description = :Description, 
                    IPAddress = :IPAddress, 
                    PicPathIn = :PicPathIn, 
                    PicPathOut = :PicPathOut, 
                    VideoPath = :VideoPath, 
                    Inactive = :Inactive, 
                    GateID = :GateID,
                    VideoDays = :VideoDays
                    WHERE PCID = :PCID';
            $stmt = $db->prepare($sql);
            return $stmt->execute([

                ':ComputerName' => $data['ComputerName'],
                ':Description' => $data['Description'],
                ':IPAddress' => $data['IPAddress'],
                ':PicPathIn' => $data['PicPathIn'],
                ':PicPathOut' => $data['PicPathOut'],
                ':VideoPath' => $data['VideoPath'],
                ':Inactive' => isset($data['Inactive']) ? 0 : 1,
                ':GateID' => $data['GateID'],
                ':VideoDays' => $data['VideoDays'] ?? 0,
                ':PCID' => $data['PCID']
            ]);
        } catch (PDOException $e) {
            // Ghi log hoặc hiển thị thông báo tùy môi trường
            error_log("DB Update Error: " . $e->getMessage());
            return false;
        }
    }

}

?>