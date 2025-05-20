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
         $stmt = $db->query("SELECT * FROM [tblLane]");    
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

    }
