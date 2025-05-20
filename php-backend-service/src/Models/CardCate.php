<?php 

namespace App\Models;
use App\Services\Database;
use PDO;

 class CardCate
 {
     protected $db;

     public function __construct()
     {
         $this->db = Database::getInstance();
     }

     public static function all()
     {
         $db = Database::getInstance();
         $stmt = $db->query("SELECT * FROM [tblCardGroup] WHERE Inactive = 0");    
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

    }
