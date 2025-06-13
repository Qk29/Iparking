<?php 

namespace App\Models;
use App\Services\Database;
use PDO;
use PDOException;
// use PhpOffice\PhpSpreadsheet\Calculation\Token\Stack;

 class Lane
 {
     protected $db;

     public function __construct()
     {
         $this->db = Database::getInstance();
     }

    public static function all()
    {
         $db = Database::getInstance();
         $stmt = $db->query("SELECT l.*, c.ComputerName FROM [tblLane] as l LEFT JOIN [tblPC] as c ON l.PCID = c.PCID");    
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addLane($data){
        try {
            
            $sql = "INSERT INTO [tblLane] (
                LaneName, PCID, LaneType,
                C1, C2, C3, C4, C5, C6,
                CheckPlateLevelIn, CheckPlateLevelOut, CheckPlateOutOption2,
                OpenBarrieIn, OpenBarrieOption1, OpenBarrieOption2,
                VehicleTypeLeft, VehicleTypeRight, CardTypeLeft, CardTypeRight,
                IsLoop, IsPrint, IsFree, IsLED, Inactive
            ) VALUES (
                :LaneName, :PCID, :LaneType,
                :C1, :C2, :C3, :C4, :C5, :C6,
                :CheckPlateLevelIn, :CheckPlateLevelOut, :CheckPlateOutOption2,
                :OpenBarrieIn, :OpenBarrieOption1, :OpenBarrieOption2,
                :VehicleTypeLeft, :VehicleTypeRight, :CardTypeLeft, :CardTypeRight,
                :IsLoop, :IsPrint, :IsFree, :IsLED, :Inactive
            )";

            $db = Database::getInstance();
            $stmt = $db->prepare($sql);
            

            return $stmt->execute([
                ':LaneName'             => $data['LaneName'] ?? '',
                ':PCID'                 => $data['PCID'] ?? '',
                ':LaneType'             => $data['LaneType'] ?? 0,
                ':C1'                   => $data['C1'] ?? 0,
                ':C2'                   => $data['C2'] ?? 0,
                ':C3'                   => $data['C3'] ?? 0,
                ':C4'                   => $data['C4'] ?? 0,
                ':C5'                   => $data['C5'] ?? 0,
                ':C6'                   => $data['C6'] ?? 0,
                ':CheckPlateLevelIn'    => $data['CheckPlateLevelIn'] ?? 0,
                ':CheckPlateLevelOut'   => $data['CheckPlateLevelOut'] ?? 0,
                ':CheckPlateOutOption2' => $data['CheckPlateOutOption2'] ?? 0,
                ':OpenBarrieIn'         => $data['OpenBarrieIn'] ?? 0,
                ':OpenBarrieOption1'    => $data['OpenBarrieOption1'] ?? 0,
                ':OpenBarrieOption2'    => $data['OpenBarrieOption2'] ?? 0,
                ':VehicleTypeLeft'      => is_array($data['VehicleTypeLeft'] ?? 0) ? implode(',', $data['VehicleTypeLeft']) : ($data['VehicleTypeLeft'] ?? 0),
                ':VehicleTypeRight'     => is_array($data['VehicleTypeRight'] ?? 0) ? implode(',', $data['VehicleTypeRight']) : ($data['VehicleTypeRight'] ?? 0),
                ':CardTypeLeft'         => is_array($data['CardTypeLeft'] ?? 0) ? implode(',', $data['CardTypeLeft']) : ($data['CardTypeLeft'] ?? 0),
                ':CardTypeRight'        => is_array($data['CardTypeRight'] ?? 0) ? implode(',', $data['CardTypeRight']) : ($data['CardTypeRight'] ?? 0),
                ':IsLoop'               => $data['IsLoop'] ?? 0,
                ':IsPrint'              => $data['IsPrint'] ?? 0,
                ':IsFree'               => $data['IsFree'] ?? 0,
                ':IsLED'                => $data['IsLED'] ?? 0,
                ':Inactive'             => $data['Inactive'] ?? 0,
            ]);
        } catch (PDOException $e) {
            // Log the error or handle it as needed
            error_log("DB Insert Error: " . $e->getMessage());
            return false;
        }
    }

    public static function findLaneById($id){
        try {
            $sql = "SELECT * FROM [tblLane] WHERE LaneID = :id";
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

    public static function updateLane($id, $data) {
        try {
            $sql = "UPDATE [tblLane] SET 
                LaneName = :LaneName,
                PCID = :PCID,
                LaneType = :LaneType,
                C1 = :C1,
                C2 = :C2,
                C3 = :C3,
                C4 = :C4,
                C5 = :C5,
                C6 = :C6,
                CheckPlateLevelIn = :CheckPlateLevelIn,
                CheckPlateLevelOut = :CheckPlateLevelOut,
                CheckPlateOutOption2 = :CheckPlateOutOption2,
                OpenBarrieIn = :OpenBarrieIn,
                OpenBarrieOption1 = :OpenBarrieOption1,
                OpenBarrieOption2 = :OpenBarrieOption2,
                VehicleTypeLeft = :VehicleTypeLeft,
                VehicleTypeRight = :VehicleTypeRight,
                CardTypeLeft = :CardTypeLeft,
                CardTypeRight = :CardTypeRight,
                IsLoop = :IsLoop,
                IsPrint = :IsPrint,
                IsFree = :IsFree,
                IsLED = :IsLED,
                Inactive = :Inactive
            WHERE LaneID = :id";

            $db = Database::getInstance();
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':id'                   => $id,
                ':LaneName'             => $data['LaneName'] ?? '',
                ':PCID'                 => $data['PCID'] ?? '',
                ':LaneType'             => $data['LaneType'] ?? 0,
                ':C1'                   => $data['C1'] ?? 0,
                ':C2'                   => $data['C2'] ?? 0,
                ':C3'                   => $data['C3'] ?? 0,
                ':C4'                   => $data['C4'] ?? 0,
                ':C5'                   => $data['C5'] ?? 0,
                ':C6'                   => $data['C6'] ?? 0,
                ':CheckPlateLevelIn'    => $data['CheckPlateLevelIn'] ?? 0,
                ':CheckPlateLevelOut'   => $data['CheckPlateLevelOut'] ?? 0,
                ':CheckPlateOutOption2' => $data['CheckPlateOutOption2'] ?? 0,
                ':OpenBarrieIn'         => $data['OpenBarrieIn'] ?? 0,
                ':OpenBarrieOption1'    => $data['OpenBarrieOption1'] ?? 0,
                ':OpenBarrieOption2'    => $data['OpenBarrieOption2'] ?? 0,
                ':VehicleTypeLeft'      => is_array($data['VehicleTypeLeft'] ?? 0) ? implode(',', $data['VehicleTypeLeft']) : ($data['VehicleTypeLeft'] ?? 0),
                ':VehicleTypeRight'     => is_array($data['VehicleTypeRight'] ?? 0) ? implode(',', $data['VehicleTypeRight']) : ($data['VehicleTypeRight'] ?? 0),
                ':CardTypeLeft'         => is_array($data['CardTypeLeft'] ?? 0) ? implode(',', $data['CardTypeLeft']) : ($data['CardTypeLeft'] ?? 0),
                ':CardTypeRight'        => is_array($data['CardTypeRight'] ?? 0) ? implode(',', $data['CardTypeRight']) : ($data['CardTypeRight'] ?? 0),
                ':IsLoop'               => $data['IsLoop'] ?? 0,
                ':IsPrint'              => $data['IsPrint'] ?? 0,
                ':IsFree'               => $data['IsFree'] ?? 0,
                ':IsLED'                => $data['IsLED'] ?? 0,
                ':Inactive'             => $data['Inactive'] ?? 0,
            ]);
        } catch (PDOException $e) {
            error_log("DB Update Error: " . $e->getMessage());
            return false;
        }
    }

    public static function DeleteLane($id){
        try {
            $sql = "DELETE FROM [tblLane] WHERE LaneID = :id";
            $db = Database::getInstance();
            $stmt = $db->prepare($sql);
            return $stmt->execute([':id' => $id]);
            
        } catch (PDOException $e) {
            error_log("DB  Delete Error: " . $e->getMessage());
            return false;
        }
    }
}
