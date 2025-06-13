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

        public function getVehiclesIn($fromDate, $toDate, $offset = 0, $limit = 50) {
            $sql = "SELECT c.CardNumber, c.DatetimeIn, c.PlateIn, c.PlateOut FROM dbo.tblCardEvent as c  
                    WHERE EventCode = 1 
                    AND DatetimeIn BETWEEN :from_date AND :to_date
                    ORDER BY DatetimeIn DESC
                    OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY";

            $stmt = $this->db2->prepare($sql);
            $stmt->bindValue(':from_date', $fromDate);
            $stmt->bindValue(':to_date', $toDate);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                error_log(print_r($stmt->errorInfo(), true));
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getVehiclesOut($fromDate, $toDate,$offset = 0, $limit = 50) {
            $sql = "SELECT c.CardNumber, c.DatetimeIn, c.DateTimeOut, c.PlateIn, c.PlateOut FROM dbo.tblCardEvent as c 
            WHERE EventCode = 2 
              AND DateTimeOut BETWEEN :from_date AND :to_date
            ORDER BY DateTimeOut DESC
            OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY";

            $stmt = $this->db2->prepare($sql);
            $stmt->bindValue(':from_date', $fromDate);
            $stmt->bindValue(':to_date', $toDate);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                error_log(print_r($stmt->errorInfo(), true));
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>