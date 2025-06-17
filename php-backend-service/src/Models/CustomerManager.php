<?php 

namespace App\Models;

use App\Services\Database;
use PDO;
use PDOException;

class CustomerManager{
    protected $db;
    public function __construct(){
        $this->db = Database::getInstance();
    }
    public static function getAllCustomer(){
        
        $sql = "SELECT cu.*, cp.CompartmentName, cg.CustomerGroupName FROM [tblCustomer] as cu LEFT JOIN [tblCompartment] as cp ON cu.CompartmentID = cp.CompartmentID
        LEFT JOIN [tblCustomerGroup] as cg ON cu.CustomerGroupID = cg.CustomerGroupID";
        $db = Database::getInstance();
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addCustomer($data) {
        
        try{
    $sql = "INSERT INTO [tblCustomer] (
        CustomerCode,
        CustomerName,
        IDNumber,
        Mobile,
        CustomerGroupID,
        CompartmentID,
        Address,
        EnableAccount,
        Account,
        Password,
        Avatar,
        Inactive,
        DateInConstruction,
        Birthday,
        DateUpdate,
        AccessLevelID,
        Finger1,
        Finger2,
        UserIDofFinger,
        DevPass,
        AccessExpireDate,
        UserFaceId

    )OUTPUT INSERTED.CustomerID VALUES (
        :CustomerCode,
        :CustomerName,
        :IDNumber,
        :Mobile,
        :CustomerGroupID,
        :CompartmentID,
        :Address,
        :EnableAccount,
        :Account,
        :Password,
        :Avatar,
        :Inactive,
        :DateInConstruction,
        :Birthday,
        :DateUpdate,
        :AccessLevelID,
        :Finger1,
        :Finger2,
        :UserIDofFinger,
        :DevPass,
        :AccessExpireDate,
        :UserFaceId
    )";

    $db = Database::getInstance();
    $stmt = $db->prepare($sql);

    

    $stmt->bindValue(':CustomerCode',     $data['CustomerCode']);
    $stmt->bindValue(':CustomerName',     $data['CustomerName']);
    $stmt->bindValue(':IDNumber',         $data['IDNumber']);
    $stmt->bindValue(':Mobile',           $data['Mobile']);
    $stmt->bindValue(':CustomerGroupID',  $data['CustomerGroupID'], PDO::PARAM_STR);
    $stmt->bindValue(':CompartmentID',    $data['CompartmentID'],PDO::PARAM_STR);
    $stmt->bindValue(':Address',          $data['Address']);
    $stmt->bindValue(':EnableAccount',    $data['EnableAccount']);
    $stmt->bindValue(':Account',          $data['Account']) ?? null;
    $stmt->bindValue(':Password',         $data['Password'] ?? null, PDO::PARAM_STR); // Không mã hóa, giữ nguyên giá trị
    $stmt->bindValue(':Avatar', $data['Avatar'] ?? null);
    $stmt->bindValue(':Inactive',         $data['Inactive'] ?? 0);
    $stmt->bindValue(':DateInConstruction', $data['DateInConstruction'] ?? date('Y-m-d H:i:s'));
    $stmt->bindValue(':Birthday',         $data['Birthday'] ?? date('Y-m-d H:i:s'));
    $stmt->bindValue(':DateUpdate',       $data['DateUpdate'] ?? date('Y-m-d H:i:s'));
    $stmt->bindValue(':AccessLevelID',    $data['AccessLevelID'] ?? '0');
    $stmt->bindValue(':Finger1',          $data['Finger1'] ?? '0');
    $stmt->bindValue(':Finger2',          $data['Finger2'] ?? '0');
    $stmt->bindValue(':UserIDofFinger',   $data['UserIDofFinger'] ?? '0');
    $stmt->bindValue(':DevPass',          $data['DevPass'] ?? '0');
    $stmt->bindValue(':AccessExpireDate', $data['AccessExpireDate'] ?? date('Y-m-d H:i:s'));
    $stmt->bindValue(':UserFaceId',       $data['UserFaceId'] ?? '0');

    
        $stmt->execute();
        $CustomerID = $stmt->fetchColumn();
        return $CustomerID;
    } catch (PDOException $e) {
    error_log('DB Error: ' . $e->getMessage());
    return false;
}
}

public static function findCustomer($id) {
    try{
        $sql = "SELECT * FROM [tblCustomer] WHERE CustomerID = :id";
        $db = Database::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }catch (PDOException $e) {
    error_log('DB Error: ' . $e->getMessage());
    return false;
}
}

    public static function updateCustomer($CustomerID,$data) {
        try {
            $sql = "UPDATE [tblCustomer] SET
                CustomerCode = :CustomerCode,
                CustomerName = :CustomerName,
                IDNumber = :IDNumber,
                Mobile = :Mobile,
                CustomerGroupID = :CustomerGroupID,
                CompartmentID = :CompartmentID,
                Address = :Address,
                EnableAccount = :EnableAccount,
                Account = :Account,
                Password = :Password,
                Avatar = :Avatar,
                Inactive = :Inactive,
                DateInConstruction = :DateInConstruction,
                Birthday = :Birthday,
                DateUpdate = :DateUpdate,
                AccessLevelID = :AccessLevelID,
                Finger1 = :Finger1,
                Finger2 = :Finger2,
                UserIDofFinger = :UserIDofFinger,
                DevPass = :DevPass,
                AccessExpireDate = :AccessExpireDate,
                UserFaceId = :UserFaceId
                WHERE CustomerID = :CustomerID";

            $db = Database::getInstance();
            $stmt = $db->prepare($sql);

            // Gán giá trị mà không mã hóa mật khẩu
            $stmt->bindValue(':CustomerID', $data['CustomerID'], PDO::PARAM_STR);
            $stmt->bindValue(':CustomerCode', $data['CustomerCode'] ?? '');
            $stmt->bindValue(':CustomerName', $data['CustomerName'] ?? '');
            $stmt->bindValue(':IDNumber', $data['IDNumber'] ?? '');
            $stmt->bindValue(':Mobile', $data['Mobile'] ?? '');
            $stmt->bindValue(':CustomerGroupID', $data['CustomerGroupID'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':CompartmentID', $data['CompartmentID'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':Address', $data['Address'] ?? '');
            $stmt->bindValue(':EnableAccount', $data['EnableAccount'] ?? 0, PDO::PARAM_INT);
            $stmt->bindValue(':Account', $data['Account'] ?? '');
            $stmt->bindValue(':Password', $data['Password'] ?? '', PDO::PARAM_STR); // Không mã hóa, giữ nguyên giá trị
            $stmt->bindValue(':Avatar', $data['Avatar'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':Inactive', $data['Inactive'] ?? 0, PDO::PARAM_INT);
            $stmt->bindValue(':DateInConstruction', $data['DateInConstruction'] ?? date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':Birthday', $data['Birthday'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':DateUpdate', date('Y-m-d H:i:s'), PDO::PARAM_STR); // Cập nhật thời gian hiện tại
            $stmt->bindValue(':AccessLevelID', $data['AccessLevelID'] ?? '0', PDO::PARAM_STR);
            $stmt->bindValue(':Finger1', $data['Finger1'] ?? '0', PDO::PARAM_STR);
            $stmt->bindValue(':Finger2', $data['Finger2'] ?? '0', PDO::PARAM_STR);
            $stmt->bindValue(':UserIDofFinger', $data['UserIDofFinger'] ?? '0', PDO::PARAM_STR);
            $stmt->bindValue(':DevPass', $data['DevPass'] ?? '0', PDO::PARAM_STR);
            $stmt->bindValue(':AccessExpireDate', $data['AccessExpireDate'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':UserFaceId', $data['UserFaceId'] ?? 0, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('DB Error: ' . $e->getMessage());
            return false;
        }
    }

    public static function deleteCustomer($id) {
        try {
            $sql = "DELETE FROM [tblCustomer] WHERE CustomerID = :id";
            $db = Database::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute([':id' => $id]);
            return true;
        } catch (PDOException $e) {
            error_log('DB Error: ' . $e->getMessage());
            return false;
        }
    }

}

?>