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
        $sql = "SELECT c.*, cg.CardGroupName, cu.CustomerName,cu.Address,cu.CompartmentId, cug.CustomerGroupName, cu.CustomerCode 
                FROM [tblCard] AS c
                LEFT JOIN [tblCardGroup] AS cg ON c.CardGroupID = cg.CardGroupID
                LEFT JOIN [tblCustomer] AS cu ON TRY_CAST(c.CustomerID AS uniqueidentifier) = cu.CustomerID
                LEFT JOIN [tblCustomerGroup] AS cug ON cu.CustomerGroupID = cug.CustomerGroupID";
        $db = Database::getInstance();
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    } catch (PDOException $e) {
        error_log("Error fetching all cards: " . $e->getMessage());
        return [];
    }
    }
}