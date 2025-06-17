<?php 

namespace App\Models;

use App\Services\Database;
use PDO;
use PDOException;

class CardManager {
    protected $db;
    public function __construct() {
        $this->db = Database::getInstance();
    }
    public static function getAllCard() {
        try {
        $sql = "SELECT c.*, cg.CardGroupName, cu.CustomerName,cu.Address,cu.CompartmentId,cp.CompartmentName, cug.CustomerGroupName, cu.CustomerCode 
                FROM [tblCard] AS c
                LEFT JOIN [tblCardGroup] AS cg ON c.CardGroupID = cg.CardGroupID
                LEFT JOIN [tblCustomer] AS cu ON TRY_CAST(c.CustomerID AS uniqueidentifier) = cu.CustomerID
                LEFT JOIN [tblCustomerGroup] AS cug ON cu.CustomerGroupID = cug.CustomerGroupID
                LEFT JOIN [tblCompartment] AS cp ON cu.CompartmentID = cp.CompartmentID";
        $db = Database::getInstance();
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    } catch (PDOException $e) {
        error_log("Error fetching all cards: " . $e->getMessage());
        return [];
    }
    }

    public static function addCard($data) {
        try {
            $db = Database::getInstance();
            $sql = "INSERT INTO [tblCard] (
                        CardNo, CardGroupID, Description, CardNumber,
                        DateRegister, DateRelease, ImportDate, ExpireDate, IsLock,
                        Plate1, Plate2, Plate3,
                        VehicleName1, VehicleName2, VehicleName3,
                        CustomerID
                    ) VALUES (
                        :CardNo, :CardGroupID, :Description, :CardNumber,
                        :DateRegister, :DateRelease, :ImportDate, :ExpireDate, :IsLock,
                        :Plate1, :Plate2, :Plate3,
                        :VehicleName1, :VehicleName2, :VehicleName3,
                        :CustomerID
                    )";

            $stmt = $db->prepare($sql);

            $stmt->execute([
                ':CardNo' => $data['CardNo'],
                ':CardGroupID' => $data['CardGroupID'],
                ':Description' => $data['Description'],
                ':CardNumber' => $data['CardNumber'],
                ':DateRegister' => $data['DateRegister'],
                ':DateRelease' => $data['DateRelease'],
                ':ImportDate' => $data['ImportDate'],
                ':ExpireDate' => $data['ExpireDate'],
                ':IsLock' => $data['IsLock'],
                ':Plate1' => $data['Plate1'],
                ':Plate2' => $data['Plate2'],
                ':Plate3' => $data['Plate3'],
                ':VehicleName1' => $data['VehicleName1'],
                ':VehicleName2' => $data['VehicleName2'],
                ':VehicleName3' => $data['VehicleName3'],
                ':CustomerID' => $data['CustomerID']
            ]);

                return true;
            } catch (PDOException $e) {
                error_log("Error adding card: " . $e->getMessage());
                return false;
            }
        }


}