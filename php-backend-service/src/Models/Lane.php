<?php 

namespace App\Models;
use App\Services\Database;
use PDO;

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

    }
