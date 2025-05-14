<?php 
    namespace App\Models;
    use App\Services\Database;
    use PDO;

    class EventCard {
        protected $db2;
        public function __construct()
        {
            $this->db2 = Database::getSecondInstance();
           
        }

        public function countVehiclesIn($fromDate, $toDate) {
            $sql = "SELECT COUNT(*) as total FROM dbo.tblCardEvent  WHERE EventCode = 1 AND DatetimeIn BETWEEN :from_date AND :to_date";
            $stmt = $this->db2->prepare($sql);
            if (!$stmt->execute(['from_date' => $fromDate, 'to_date' => $toDate])) {
            error_log(print_r($stmt->errorInfo(), true));
            }
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function countVehiclesOut($fromDate, $toDate) {
            $sql = "SELECT COUNT(*) as total FROM dbo.tblCardEvent  WHERE EventCode = 2 AND DateTimeOut BETWEEN :from_date AND :to_date";
            $stmt = $this->db2->prepare($sql);
            if (!$stmt->execute(['from_date' => $fromDate, 'to_date' => $toDate])) {
                error_log(print_r($stmt->errorInfo(), true));
            }
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

?>