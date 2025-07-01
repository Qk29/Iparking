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
        $sql = "SELECT c.*, cg.CardGroupName, cu.CustomerName,cu.Address,cu.CompartmentId,cu.CustomerGroupID,cp.CompartmentName, cug.CustomerGroupName, cu.CustomerCode 
                FROM [tblCard] AS c
                LEFT JOIN [tblCardGroup] AS cg ON TRY_CAST(c.CardGroupID AS uniqueidentifier) = cg.CardGroupID
                LEFT JOIN [tblCustomer] AS cu ON TRY_CAST(c.CustomerID AS uniqueidentifier) = cu.CustomerID
                LEFT JOIN [tblCustomerGroup] AS cug ON TRY_CAST(cu.CustomerGroupID AS uniqueidentifier) = cug.CustomerGroupID
                LEFT JOIN [tblCompartment] AS cp ON TRY_CAST(cu.CompartmentId AS uniqueidentifier) = cp.CompartmentID";
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

                // Truy vấn lại CardID vừa thêm dựa vào CardNumber (giả sử CardNumber là duy nhất)
                $stmt2 = $db->prepare("SELECT CardID FROM [tblCard] WHERE CardNumber = :CardNumber ORDER BY DateRegister DESC");
                $stmt2->execute([':CardNumber' => $data['CardNumber']]);
                $row = $stmt2->fetch(PDO::FETCH_ASSOC);
                return $row ? $row['CardID'] : false;
            } catch (PDOException $e) {
                error_log("Error adding card: " . $e->getMessage());
                return false;
            }
        }

    public static function findCard($id) {
        try {
            $db = Database::getInstance();
            $sql = "SELECT c.*, cg.CardGroupName, cu.CustomerName, cu.Address,cu.IDNumber, cu.CompartmentId, cu.CustomerGroupID, cp.CompartmentName, cug.CustomerGroupName, cu.CustomerCode 
                    FROM [tblCard] AS c
                    LEFT JOIN [tblCardGroup] AS cg ON c.CardGroupID = cg.CardGroupID
                    LEFT JOIN [tblCustomer] AS cu ON TRY_CAST(c.CustomerID AS uniqueidentifier) = cu.CustomerID
                    LEFT JOIN [tblCustomerGroup] AS cug ON cu.CustomerGroupID = cug.CustomerGroupID
                    LEFT JOIN [tblCompartment] AS cp ON cu.CompartmentId = cp.CompartmentID
                    WHERE c.CardID = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error finding card: " . $e->getMessage());
            return null;
        }
    }

    public static function updateCard($id, $data) {
    try {
        $db = Database::getInstance();
        $sql = "UPDATE [tblCard] SET 
                    CardNo = :CardNo,
                    CardGroupID = :CardGroupID,
                    Description = :Description,
                    CardNumber = :CardNumber,
                    DateRegister = :DateRegister,
                    DateRelease = :DateRelease,
                    ImportDate = :ImportDate,
                    ExpireDate = :ExpireDate,
                    IsLock = :IsLock,
                    Plate1 = :Plate1,
                    Plate2 = :Plate2,
                    Plate3 = :Plate3,
                    VehicleName1 = :VehicleName1,
                    VehicleName2 = :VehicleName2,
                    VehicleName3 = :VehicleName3,
                    CustomerID = :CustomerID,
                    DateUpdate = GETDATE()
                WHERE CardID = :CardID";

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
            ':CustomerID' => $data['CustomerID'],
            ':CardID' => $id
        ]);

        return true;
    } catch (PDOException $e) {
        error_log("Error updating card: " . $e->getMessage());
        return false;
    }
}

    public static function deleteCard($id) {
        try {
            $db = Database::getInstance();
            $sql = "DELETE FROM [tblCard] WHERE CardID = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->rowCount() > 0; // Trả về true nếu có ít nhất 1 dòng bị xóa
        } catch (PDOException $e) {
            error_log("Error deleting card: " . $e->getMessage());
            return false;
        }
    }

    public static function bulkUpdateLockModel($data) {
    try {
        $db = Database::getInstance();
        
        $cardIds = $data['card_ids']; // lưu ý key là 'card_ids' giống bên PHP gọi API
        $isLock = $data['is_lock'];

        if (empty($cardIds) || !is_array($cardIds)) {
            return false;
        }

        // Tạo các placeholder kiểu :id0, :id1,...
        $placeholders = [];
        foreach ($cardIds as $index => $cardId) {
            $placeholders[] = ":id$index";
        }

        $sql = "UPDATE [tblCard] SET IsLock = :IsLock WHERE CardID IN (" . implode(",", $placeholders) . ")";
        $stmt = $db->prepare($sql);

        // Bind biến IsLock
        $stmt->bindValue(':IsLock', $isLock, PDO::PARAM_INT);

        // Bind từng CardID theo placeholder
        foreach ($cardIds as $index => $cardId) {
            $stmt->bindValue(":id$index", $cardId);
        }

        $stmt->execute();
        return $cardIds; // Trả về danh sách CardID đã cập nhật
    } catch (PDOException $e) {
        error_log("Error bulk updating lock model: " . $e->getMessage());
        return false;
    }
}

public static function bulkUpdateUnlockModel($data) {
    try {
        $db = Database::getInstance();
        
        $cardIds = $data['card_ids']; // lưu ý key là 'card_ids' giống bên PHP gọi API
        $isLock = $data['is_lock'];

        if (empty($cardIds) || !is_array($cardIds)) {
            return false;
        }

        // Tạo các placeholder kiểu :id0, :id1,...
        $placeholders = [];
        foreach ($cardIds as $index => $cardId) {
            $placeholders[] = ":id$index";
        }

        $sql = "UPDATE [tblCard] SET IsLock = :IsLock WHERE CardID IN (" . implode(",", $placeholders) . ")";
        $stmt = $db->prepare($sql);

        // Bind biến IsLock
        $stmt->bindValue(':IsLock', $isLock, PDO::PARAM_INT);

        // Bind từng CardID theo placeholder
        foreach ($cardIds as $index => $cardId) {
            $stmt->bindValue(":id$index", $cardId);
        }

        $stmt->execute();
        return $cardIds; // Trả về danh sách CardID đã cập nhật
    } catch (PDOException $e) {
        error_log("Error bulk updating unlock model: " . $e->getMessage());
        return false;
    }
}

    public static function renewCardsModel($data) {
        try {
            $db = Database::getInstance();
            $cardIds = $data['cardIds']; 
            $newExpireDate = $data['newExpireDate'];

            if (empty($cardIds) || !is_array($cardIds)) {
                return false;
            }

            // Tạo các placeholder kiểu :id0, :id1,...
            $placeholders = [];
            foreach ($cardIds as $index => $cardId) {
                $placeholders[] = ":id$index";
            }

            $sql = "UPDATE [tblCard] SET ExpireDate = :ExpireDate WHERE CardID IN (" . implode(",", $placeholders) . ")";
            $stmt = $db->prepare($sql);

            // Bind biến ExpireDate
            $stmt->bindValue(':ExpireDate', $newExpireDate, PDO::PARAM_STR);

            // Bind từng CardID theo placeholder
            foreach ($cardIds as $index => $cardId) {
                $stmt->bindValue(":id$index", $cardId);
            }

            $stmt->execute();
            return $cardIds; // Trả về danh sách CardID đã cập nhật
        } catch (PDOException $e) {
            error_log("Error renewing cards: " . $e->getMessage());
            return false;
        }
    }

    public static function activateCardsModel($data) {
        try {
            $db = Database::getInstance();
            $cardIds = $data['cardids']; 
            error_log("[DEBUG] activateCardsModel received cardIds: " . json_encode($cardIds));
            $newDateActive = $data['newDateActive'];

            if (empty($cardIds) || !is_array($cardIds)) {
                return false;
            }

            // Tạo các placeholder kiểu :id0, :id1,...
            $placeholders = [];
            foreach ($cardIds as $index => $cardId) {
                $placeholders[] = ":id$index";
            }

            $sql = "UPDATE [tblCard] SET DateActive = :DateActive WHERE CardID IN (" . implode(",", $placeholders) . ")";
            $stmt = $db->prepare($sql);

            // Bind biến DateActive
            $stmt->bindValue(':DateActive', $newDateActive, PDO::PARAM_STR);

            // Bind từng CardID theo placeholder
            foreach ($cardIds as $index => $cardId) {
                $stmt->bindValue(":id$index", $cardId);
            }

            $stmt->execute();
            return $cardIds; // Trả về danh sách CardID đã cập nhật
        } catch (PDOException $e) {
            error_log("Error activating cards: " . $e->getMessage());
            return false;
        }
    }


}