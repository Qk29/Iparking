<?php 
    namespace App\Controllers;
    use App\Models\CardCate;

    
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    class CardCategoryController {
        public function index(Request $request, Response $response): Response
        {
            $cardCategories = CardCate::all();
            $response->getBody()->write(json_encode($cardCategories));
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function create(Request $request, Response $response): Response
        {
            $params = (array) $request->getParsedBody();

            error_log("Params received: " . print_r($params, true));
            
            $CardGroupName = $params['CardGroupName'] ?? '';
            $Description = $params['Description'] ?? 'chưa có mô tả';
            $CardType = $params['CardType'] ?? 0;
            $VehicleGroupID = $params['VehicleGroupID'] ?? 0;
            $ValidTimeStart = $params['ValidTimeStart'] ?? '00:00';
            $ValidTimeEnd = $params['ValidTimeEnd'] ?? '23:59';
            $Formulation = $params['Formulation'] ?? 0;
            $FreeTime = $params['FreeTime'] ?? 0;
            $IsHaveMoneyExcessTime = $params['IsHaveMoneyExcessTime'] ?? 0;
            $EnableFree = $params['EnableFree'] ?? 0;
            $DayTimeFrom = $params['DayTimeFrom'] ?? '00:00';
            $DayTimeTo = $params['DayTimeTo'] ?? '23:59';
            $EachFee = $params['EachFee'] ?? 0;
            $SortOrder = $params['SortOrder'] ?? 0;
            $RestrictedNumber = $params['RestrictedNumber'] ?? 0;
            $IsCheckPlate = $params['IsCheckPlate'] ?? 0;
            $IsHaveMoneyExpiredDate = $params['IsHaveMoneyExpiredDate'] ?? 0;
            $Inactive = $params['Inactive'] ?? 0;
            $IsSpecialGroup = $params['IsSpecialGroup'] ?? 0;
            $isLockingCharge = $params['isLockingCharge'] ?? 0;
            $LaneIDs = $params['listLanes'] ?? '';
            $Block0 = $params['Block0'] ?? 0;
            $Time0 = $params['Time0'] ?? 0;
            $Block1 = $params['Block1'] ?? 0;
            $Time1 = $params['Time1'] ?? 0;
            $Block2 = $params['Block2'] ?? 0;
            $Time2 = $params['Time2'] ?? 0;
            $Block3 = $params['Block3'] ?? 0;
            $Time3 = $params['Time3'] ?? 0;
            $Block4 = $params['Block4'] ?? 0;

            $Time4 = $params['Time4'] ?? 0;
            $Block5 = $params['Block5'] ?? 0;
            $Time5 = $params['Time5'] ?? 0;
            $TimePeriods = $params['TimePeriods'] ?? '00:00-00:00-00:00-00:00-00:00';
            $Costs = $params['Costs'] ?? 0;

            // if (!$CardGroupName || !$CardType || !$VehicleGroupID || !$ValidTimeStart || !$ValidTimeEnd || !$Formulation) {
            //     $response->getBody()->write(json_encode(['message' => 'Thiếu dữ liệu bắt buộc']));
            //     return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            // }

            
            try {
                CardCate::createCardCategory($CardGroupName, $Description, $CardType, $VehicleGroupID, $ValidTimeStart, $ValidTimeEnd, $Formulation, $FreeTime, $IsHaveMoneyExcessTime, $EnableFree, $DayTimeFrom, $DayTimeTo, $EachFee, $SortOrder, $IsCheckPlate,$RestrictedNumber, $IsHaveMoneyExpiredDate, $Inactive, $IsSpecialGroup, $isLockingCharge, $LaneIDs ,$Block0 ,$Time0 ,$Block1 ,$Time1 ,$Block2 ,$Time2 ,$Block3 ,$Time3 ,$Block4 ,$Time4 ,$Block5 ,$Time5, $TimePeriods, $Costs);
                $response->getBody()->write(json_encode(['success' => true, 'message' => 'Tạo nhóm thẻ thành công']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
            } catch (\Exception $e) {
               error_log("Error in createCardCategory: " . $e->getMessage());
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'Lỗi khi tạo danh mục thẻ: ' . $e->getMessage()]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            }

        }

        

        public function delete(Request $request, Response $response, $args): Response {
            $CardGroupID = $args['id'];
            try {
                CardCate::softDeleteCardGroup($CardGroupID);
                $response->getBody()->write(json_encode([
                    'success' => true,
                    'message' => "Xoá nhóm thẻ thành công"
                ]));

                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            } catch (\Exception $e) {
                $response->getBody()->write(json_encode([
                    'success' => false,
                    'message' => "Xoá nhóm thẻ thất bại" . $e->getMessage()
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);  
            }
        }

        public function findCardCategory(Request $request, Response $response, $args): Response {
            $CardGroupID = $args['id'];
            try {
                $cardCategory = CardCate::findCardGroupByID($CardGroupID);
                if ($cardCategory) {
                    $response->getBody()->write(json_encode([
                        'success' => true,
                        'data' => $cardCategory
                    ]));
                    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
                } else {
                    $response->getBody()->write(json_encode([
                        'success' => false,
                        'message' => 'Không tìm thấy nhóm thẻ',
                    ]));
                }
                
            } catch (\Exception $e) {
                $response->getBody()->write(json_encode([
                    'success' => false,
                    'message' => 'Lỗi khi tìm nhóm thẻ: ' . $e->getMessage()
                ]));
                
            }
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }

        public function update(Request $request, Response $response, $args): Response {
            $CardGroupID = $args['id'];
            $params = (array) $request->getParsedBody();

            error_log("Params received for update: " . print_r($params, true));
            
            $CardGroupName = $params['CardGroupName'] ?? '';
            $Description = $params['Description'] ?? 'chưa có mô tả';
            $CardType = $params['CardType'] ?? 0;
            $VehicleGroupID = $params['VehicleGroupID'] ?? 0;
            $ValidTimeStart = $params['ValidTimeStart'] ?? '00:00';
            $ValidTimeEnd = $params['ValidTimeEnd'] ?? '23:59';
            $Formulation = $params['Formulation'] ?? 0;
            $FreeTime = $params['FreeTime'] ?? 0;
            $IsHaveMoneyExcessTime = $params['IsHaveMoneyExcessTime'] ?? 0;
            $EnableFree = $params['EnableFree'] ?? 0;
            $DayTimeFrom = $params['DayTimeFrom'] ?? '00:00';
            $DayTimeTo = $params['DayTimeTo'] ?? '23:59';
            $EachFee = $params['EachFee'] ?? 0;
            $SortOrder = $params['SortOrder'] ?? 0;
            $RestrictedNumber = $params['RestrictedNumber'] ?? 0;
            $IsCheckPlate = $params['IsCheckPlate'] ?? 0;
            $IsHaveMoneyExpiredDate = $params['IsHaveMoneyExpiredDate'] ?? 0;
            $Inactive = $params['Inactive'] ?? 0;
            $IsSpecialGroup = $params['IsSpecialGroup'] ?? 0;
            $isLockingCharge = $params['isLockingCharge'] ?? 0;
            $LaneIDs = $params['listLanes'] ?? '';
            $Block0 = $params['Block0'] ?? 0;
            $Time0 = $params['Time0'] ?? 0;
            $Block1 = $params['Block1'] ?? 0;
            $Time1 = $params['Time1'] ?? 0;
            $Block2 = $params['Block2'] ?? 0;
            $Time2 = $params['Time2'] ?? 0;
            $Block3 = $params['Block3'] ?? 0;
            $Time3 = $params['Time3'] ?? 0;
            $Block4 = $params['Block4'] ?? 0;

            $Time4 = $params['Time4'] ?? 0;
            $Block5 = $params['Block5'] ?? 0;
            $Time5 = $params['Time5'] ?? 0;
            $TimePeriods = $params['TimePeriods'] ?? '00:00-00:00-00:00-00:00-00:00';
            $Costs = $params['Costs'] ?? 0;

            try{
                CardCate::updateCardCategory($CardGroupID,$CardGroupName, $Description, $CardType, $VehicleGroupID, $ValidTimeStart, $ValidTimeEnd, $Formulation, $FreeTime, $IsHaveMoneyExcessTime, $EnableFree, $DayTimeFrom, $DayTimeTo, $EachFee, $SortOrder, $IsCheckPlate,$RestrictedNumber, $IsHaveMoneyExpiredDate, $Inactive, $IsSpecialGroup, $isLockingCharge, $LaneIDs ,$Block0 ,$Time0 ,$Block1 ,$Time1 ,$Block2 ,$Time2 ,$Block3 ,$Time3 ,$Block4 ,$Time4 ,$Block5 ,$Time5, $TimePeriods, $Costs);
                $response->getBody()->write(json_encode(['success' => true, 'message' => 'Cập nhật nhóm thẻ thành công']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            } catch (\Exception $e) {
                error_log("Error in updateCardCategory: " . $e->getMessage());
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'Lỗi khi cập nhật danh mục thẻ: ' . $e->getMessage()]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            }
            
       
        }

        
    }

?>