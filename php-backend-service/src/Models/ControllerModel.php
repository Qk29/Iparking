<?php 
namespace App\Models;
use App\Services\Database;
use PDO;
use PDOException;

class ControllerModel {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public static function getAllControllers() {
        try {
            $sql = "SELECT ct.*, pc.ComputerName FROM [tblController] as ct
                    LEFT JOIN [tblPC] as pc ON ct.PCID = pc.PCID";
            $db = Database::getInstance();
            $stmt = $db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log the error or handle it as needed
            error_log("DB Select Error: " . $e->getMessage());
            return [];
        }
    }

    public static function addController($data) {
        try {
            $sql = "INSERT INTO [tblController] (ControllerID,ControllerName, PCID,  CommunicationType, Comport, Baudrate, LineTypeID, Reader1Type, Reader2Type,Address, Inactive) 
                    VALUES (NEWID(),:ControllerName, :PCID, :CommunicationType, :Comport, :Baudrate, :LineTypeID, :Reader1Type, :Reader2Type, :Address, :Inactive)";
            $db = Database::getInstance();
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':ControllerName' => $data['ControllerName'],
                ':PCID' => $data['PCID'],
                ':CommunicationType' => $data['CommunicationType'],
                ':Comport' => $data['Comport'],
                ':Baudrate' => $data['Baudrate'],
                ':LineTypeID' => $data['LineTypeID'],
                ':Reader1Type' => $data['Reader1Type'],
                ':Reader2Type' => $data['Reader2Type'],
                ':Address' => $data['Address'],
                ':Inactive' => isset($data['Inactive']) ? 0 : 1,
            ]);

        } catch (PDOException $e) {
            // Log the error or handle it as needed
            error_log("DB Insert Error: " . $e->getMessage());
            return false;
        }
    }

    public static function findControllerById($id){
        try {
            $sql = "SELECT * FROM [tblController] WHERE ControllerID = :id";
            $db = Database::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("DB Find Error: " . $e->getMessage());
            return false;
        }
    }

    public static function updateController($data){
        try {
            $sql = "UPDATE [tblController] SET 
                    ControllerName = :ControllerName,
                    PCID = :PCID,
                    CommunicationType = :CommunicationType,
                    Comport = :Comport,
                    Baudrate = :Baudrate,
                    LineTypeID = :LineTypeID,
                    Reader1Type = :Reader1Type,
                    Reader2Type = :Reader2Type,
                    Address = :Address,
                    Inactive = :Inactive
                    WHERE ControllerID = :ControllerID";
            $db = Database::getInstance();
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':ControllerName' => $data['ControllerName'],
                ':PCID' => $data['PCID'],
                ':CommunicationType' => $data['CommunicationType'],
                ':Comport' => $data['Comport'],
                ':Baudrate' => $data['Baudrate'],
                ':LineTypeID' => $data['LineTypeID'],
                ':Reader1Type' => $data['Reader1Type'],
                ':Reader2Type' => $data['Reader2Type'],
                ':Address' => $data['Address'],
                ':Inactive' => isset($data['Inactive']) ? 0 : 1,
                ':ControllerID' => $data['ControllerID']
            ]);
        } catch (PDOException $e) {
            error_log("DB Update Error: " . $e->getMessage());
            return false;
        }
    }

    public static function softDelete($controllerID){
        try {
            $sql = "UPDATE [tblController] SET Inactive = 1 WHERE ControllerID = :ControllerID";
            $db = Database::getInstance();
            $stmt = $db->prepare($sql);
            return $stmt->execute([':ControllerID' => $controllerID]);
        } catch (PDOException $e) {
            error_log("DB Soft Delete Error: " . $e->getMessage());
            return false;
        }
    }
}   