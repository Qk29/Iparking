<?php

namespace App\Models;

use App\Services\Database;
use PDO;
use PDOException;

class CardProcess
{
    public static function insert($data)
    {
        try {
            $pdo = Database::getInstance();
            $sql = "INSERT INTO tblCardProcess 
                    (Date, CardNumber, CardGroupID, CustomerID, UserID, Description, Plates, OldInfoCP, Actions,AccessLevelID)
                    VALUES (:Date, :CardNumber, :CardGroupID, :CustomerID, :UserID, :Description, :Plates, :OldInfoCP, :Actions, :AccessLevelID)";

            $stmt = $pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            
            error_log("Error inserting card process: " . $e->getMessage());
            error_log("[INSERT ERROR] Data: " . json_encode($data));
            return false;
        }
    }
    public static function getCardProcessDetails($cardId)
    {
        try {
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM tblCardProcess WHERE CardID = ?");
            $stmt->execute([$cardId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching card process detail: " . $e->getMessage());
            return [];
        }
    }

    public static function getFilteredProcess($action = null, $from = null, $to = null, $cardGroupID = null, $customerGroupID = null, $userID = null, $search = null)
{
    try {
        $pdo = Database::getInstance();
        $sql = "SELECT cp.*, cu.CustomerName, cu.Address, cg.CardGroupName, cug.CustomerGroupName, u.Username
                FROM tblCardProcess cp
                LEFT JOIN [tblCustomer] cu ON cu.CustomerID = TRY_CAST(cp.CustomerID AS uniqueidentifier) 
                LEFT JOIN [tblCardGroup] cg ON cg.CardGroupID = TRY_CAST(cp.CardGroupID AS uniqueidentifier)
                LEFT JOIN [tblCustomerGroup] cug ON TRY_CAST(cu.CustomerGroupID AS uniqueidentifier)= cug.CustomerGroupID
                LEFT JOIN [User] u ON u.Id = cp.UserID
                WHERE 1=1";

        $params = [];

        if ($action) {
            $sql .= " AND cp.Actions = ?";
            $params[] = $action;
        }
        if ($from) {
            $sql .= " AND cp.Date >= ?";
            $params[] = $from;
        }
        if ($to) {
            $sql .= " AND cp.Date <= ?";
            $params[] = $to;
        }
        if ($cardGroupID) {
            $sql .= " AND cp.CardGroupID = ?";
            $params[] = $cardGroupID;
        }
        if ($customerGroupID) {
            $sql .= " AND cu.CustomerGroupID = ?";
            $params[] = $customerGroupID;
        }
        if ($userID) {
            $sql .= " AND cp.UserID = ?";
            $params[] = $userID;
        }

        $sql .= " ORDER BY cp.Date DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching filtered process: " . $e->getMessage());
        return [];
    }
}

public static function getCardIssueSummary($from = null, $to = null){
    $db = Database::getInstance();
    $sql = "SELECT cg.CardGroupName,
                   SUM(CASE WHEN cp.Actions = 'ADD' THEN 1 ELSE 0 END) AS countAddCard,
                   SUM(CASE WHEN cp.Actions = 'RELEASE' THEN 1 ELSE 0 END) AS countReleaseCard,
                   SUM(CASE WHEN cp.Actions = 'ACTIVE' THEN 1 ELSE 0 END) AS countActiveCard,
                   SUM(CASE WHEN cp.Actions = 'LOCK' THEN 1 ELSE 0 END) AS countLockCard,
                   SUM(CASE WHEN cp.Actions = 'UNLOCK' THEN 1 ELSE 0 END) AS countUnlockCard,
                   SUM(CASE WHEN cp.Actions = 'DELETE' THEN 1 ELSE 0 END) AS countDeleteCard
            FROM tblCardProcess cp
            LEFT JOIN tblCardGroup cg ON cg.CardGroupID = TRY_CAST(cp.CardGroupID AS uniqueidentifier)
            WHERE 1=1";
    $params = [];
    if ($from) {
        $sql .= " AND cp.Date >= ?";
        $params[] = $from;
    }
    if ($to) {
        $sql .= " AND cp.Date <= ?";
        $params[] = $to;
    }
    $sql .= " GROUP BY cg.CardGroupName";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
