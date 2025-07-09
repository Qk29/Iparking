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

        public function getVehiclesInDetail($timeSearch) {
            try {
                // $timeSearch dạng 'Y-m-d H:i' hoặc 'Y-m-d H:i:s'
                // Nếu chỉ có phút, tự động thêm ':59.999' để lấy hết trong phút đó
                if (strlen($timeSearch) == 16) { // 'Y-m-d H:i'
                    $endTime = $timeSearch . ':59.999';
                } else {
                    $endTime = $timeSearch;
                }
                $sql = "SELECT c.CardNumber, c.DatetimeIn, c.PlateIn, c.CardNo, c.CardGroupID, 
               cg.CardGroupName, c.CustomerName, c.PicDirIn, c.LaneIDIn,l.LaneName
                FROM MPARKINGEVENTTM.dbo.tblCardEvent AS c
                LEFT JOIN MPARKINGKH.dbo.tblCardGroup AS cg
                ON c.CardGroupID = cg.CardGroupID 
                LEFT JOIN MPARKINGKH.dbo.tblLane as l
                ON c.LaneIDIn = l.LaneID
                        WHERE EventCode = 1 
                        AND DatetimeIn <= :end_time";
                $stmt = $this->db2->prepare($sql);
                $stmt->bindValue(':end_time', $endTime);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);   
            } catch (\Exception $e) {
                error_log("Error: " . $e->getMessage());
                return [];
            }
        }

        public function getCurrentVehiclesIn($filters = [], $offset = 0, $limit = 50)
        {
            try {
                $sql = "SELECT 
                            c.CardNumber, c.CardNo, c.DatetimeIn, c.PlateIn,
                            c.IsPlateInValid, c.PicDirIn, c.CardGroupID, 
                            c.CustomerName, c.CustomerGroupID, c.LaneIDIn 
                            
                        FROM [MPARKINGEVENTTM].[dbo].[tblCardEvent] AS c
                        
                        WHERE c.EventCode = 1 AND c.DateTimeOut IS NULL";

                $params = [];

                // Filter: khoảng thời gian
                if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                    $sql .= " AND c.DatetimeIn BETWEEN :from_date AND :to_date";
                    $params['from_date'] = $filters['from_date'];
                    $params['to_date'] = $filters['to_date'];
                }

                // Filter: nhóm khách hàng
                if (!empty($filters['customer_group'])) {
                    $sql .= " AND c.CustomerGroupID = :customer_group";
                    $params['customer_group'] = $filters['customer_group'];
                }

                // Filter: nhóm thẻ
                if (!empty($filters['card_group'])) {
                    $sql .= " AND c.CardGroupID = :card_group";
                    $params['card_group'] = $filters['card_group'];
                }

                // Filter: làn vào
                if (!empty($filters['lane'])) {
                    $sql .= " AND c.LaneIDIn = :lane";
                    $params['lane'] = $filters['lane'];
                }

                // Filter: từ khóa tìm kiếm (mã thẻ hoặc biển số)
                if (!empty($filters['keyword'])) {
                    $sql .= " AND (c.CardNumber LIKE :keyword OR c.PlateIn LIKE :keyword)";
                    $params['keyword'] = '%' . $filters['keyword'] . '%';
                }

                // Sắp xếp và phân trang
                $sql .= " ORDER BY c.DatetimeIn DESC OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY";

                $stmt = $this->db2->prepare($sql);

                // Bind các giá trị
                foreach ($params as $key => $val) {
                    $stmt->bindValue(':' . $key, $val);
                }

                $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
                $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);

                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (empty($data)) {
                    error_log("⚠️ Không có dữ liệu JOIN được với các điều kiện hiện tại.");
                }
                return $data;
            } catch (\Exception $e) {
                error_log("getCurrentVehiclesIn error: " . $e->getMessage());
                return [];
            }
        }

    public function getFilteredVehicleIn( $fromDate, $toDate, $customerGroupID, $cardGroupID, $search, $offset = 0, $limit = 20) {
        $sql = "SELECT c.CardNumber,c.CardNo, c.DatetimeIn, c.PlateIn, c.PicDirIn, c.IsPlateInValid, cg.CardGroupName, cu.CustomerName 
                FROM [MPARKINGEVENTTM].[dbo].[tblCardEvent] AS c
                LEFT JOIN [MPARKINGKH].[dbo].[tblCardGroup] AS cg ON Try_CAST(c.CardGroupID as uniqueidentifier) = cg.CardGroupID
                LEFT JOIN [MPARKINGKH].[dbo].[tblCustomer] AS cu ON Try_CAST(c.CustomerID as uniqueidentifier) = cu.CustomerID
                WHERE c.DatetimeIn BETWEEN :from_date AND :to_date";  
        $params = [];
        $params['from_date'] = $fromDate;
        $params['to_date'] = $toDate;
        if ($customerGroupID) {
            $sql .= " AND cu.CustomerGroupID = :cardGroupSelect";
            $params['cardGroupSelect'] = $customerGroupID;
        }
        if ($cardGroupID) {
            $sql .= " AND c.CardGroupID = :cardGroupID";
            $params['cardGroupID'] = $cardGroupID;
        }
        if ($search) {
            $sql .= " AND (c.CardNumber LIKE :search OR c.PlateIn LIKE :search)";
            $params['search'] = '%' . $search . '%';
        }
        $sql .= " ORDER BY c.DatetimeIn DESC OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY";
        
        $stmt = $this->db2->prepare($sql);
        foreach ($params as $key => $val) {
            if ($key === 'offset' || $key === 'limit') continue; // sẽ bind riêng
            $stmt->bindValue(':' . $key, $val);
        }
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  
    }
}


?>