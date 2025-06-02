<?php 
namespace App\Models;
use App\Services\Database;
use PDO;
use PDOException;

class Camera{
    protected $db;

    public function __construct(){
        $this->db = Database::getInstance();
    }
    
    public static function getAllCameras(){
        try {
            $sql = "SELECT c.*, pc.ComputerName, g.GateName 
                    FROM [tblCamera] AS c
                    LEFT JOIN [tblPC] AS pc ON c.PCID = pc.PCID
                    LEFT JOIN [tblGate] AS g ON pc.GateID = g.GateID";
            $db = Database::getInstance();
            $stmt = $db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log the error or handle it as needed
            error_log("DB Select Error: " . $e->getMessage());
            return [];
        }
    }

    public static function addCamera($data){
        try {
            $db = Database::getInstance();
            $sql = "INSERT INTO [tblCamera] (CameraID, CameraName, CameraType,PCID,HttpURL,HttpPort,RtspPort,Username,Password,Channel,StreamType,Resolution,FrameRate,SDK,EnableRecording,IsFaceRecognize,Inactive) 
                    VALUES (NEWID(), :CameraName, :CameraType, :PCID, :HttpURL, :HttpPort, :RtspPort, :Username, :Password, :Channel, :StreamType, :Resolution, :FrameRate, :SDK, :EnableRecording, :IsFaceRecognize, :Inactive)";
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':CameraName' => $data['CameraName'],
                ':CameraType' => $data['CameraType'],
                ':PCID' => $data['PCID'],
                ':HttpURL' => $data['HttpURL'],
                ':HttpPort' => $data['HttpPort'],
                ':RtspPort' => $data['RtspPort'],
                ':Username' => $data['Username'],
                ':Password' => $data['Password'],
                ':Channel' => $data['Channel'],
                ':StreamType' => $data['StreamType'],
                ':Resolution' => $data['Resolution'],
                ':FrameRate' => $data['FrameRate'] ?? null,
                ':SDK' => $data['SDK'],
                ':EnableRecording' => isset($data['EnableRecording']) ? 0 : 1,
                ':IsFaceRecognize' => isset($data['IsFaceRecognize']) ? 0 : 1,
                ':Inactive' => isset($data['Inactive']) ? 0 : 1
            ]);
        } catch (PDOException $e) {
            // Log the error or handle it as needed
            error_log("DB Insert Error: " . $e->getMessage());
            return false;
        }
    }

    public static function findCameraById($id) {
        try {
            $db = Database::getInstance();
            $stmt = $db->prepare("SELECT * FROM [tblCamera] WHERE CameraID = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log the error or handle it as needed
            error_log("DB Select Error: " . $e->getMessage());
            return false;
        }
    }

    public static function updateCamera($data) {
        try {
            $db = Database::getInstance();
            $sql = "UPDATE [tblCamera] SET 
                    CameraName = :CameraName, 
                    CameraType = :CameraType, 
                    PCID = :PCID, 
                    HttpURL = :HttpURL, 
                    HttpPort = :HttpPort, 
                    RtspPort = :RtspPort, 
                    UserName = :UserName, 
                    Password = :Password, 
                    Channel = :Channel, 
                    StreamType = :StreamType, 
                    Resolution = :Resolution, 
                    FrameRate = :FrameRate, 
                    SDK = :SDK, 
                    EnableRecording = :EnableRecording, 
                    Inactive = :Inactive
                    WHERE CameraID = :CameraID";
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':CameraName' => $data['CameraName'],
                ':CameraType' => $data['CameraType'],
                ':PCID' => $data['PCID'],
                ':HttpURL' => $data['HttpURL'],
                ':HttpPort' => $data['HttpPort'],
                ':RtspPort' => $data['RtspPort'],
                ':UserName' => $data['UserName'],
                ':Password' => $data['Password'],
                ':Channel' => $data['Channel'],
                ':StreamType' => $data['StreamType'],
                ':Resolution' => $data['Resolution'],
                ':FrameRate' => $data['FrameRate'] ?? null,
                ':SDK' => $data['SDK'],
                ':EnableRecording' => isset($data['EnableRecording']) ? 0 : 1,
                ':Inactive' => isset($data['Inactive']) ? 0 : 1,
                ':CameraID' => $data['CameraID']
            ]);
        } catch (PDOException $e) {
            // Log the error or handle it as needed
            error_log("DB Update Error: " . $e->getMessage());
            return false;
        }
    }

    public static function deleteCamera($cameraId) {
        try {
            $sql = "UPDATE [tblCamera] SET Inactive = 1 WHERE CameraID = :CameraID";
            $db = Database::getInstance();
            $stmt = $db->prepare($sql);
            return $stmt->execute([':CameraID' => $cameraId]);

        } catch (PDOException $e) {
            // Log the error or handle it as needed
            error_log("DB Delete Error: " . $e->getMessage());
            return false;
        }   
    }
}