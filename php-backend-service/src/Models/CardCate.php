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
         $stmt = $db->query("SELECT * FROM [tblCardGroup]");    
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public static function createCardCategory(
         
         $CardGroupName,
         $Description,
         $CardType,
         
         $VehicleGroupID,
         $ValidTimeStart,
         $ValidTimeEnd,
         $Formulation,
         $FreeTime,
         $IsHaveMoneyExcessTime,
         $EnableFree,
         $DayTimeFrom,
         $DayTimeTo,
         $EachFee,
         $SortOrder,
        $RestrictedNumber,
         $IsCheckPlate,
         $IsHaveMoneyExpiredDate,
         $Inactive,
         $IsSpecialGroup,
         $isLockingCharge,
         $LaneIDs ,
         $Block0, 
         $Time0, 
         $Block1 , 
         $Time1, 
         $Block2, 
         $Time2, 
         $Block3, 
         $Time3, 
         $Block4, 
         $Time4, 
         $Block5, 
         $Time5,
         $TimePeriods,
        $Costs
     )
     
     {
        error_log("Params in createCardCategory: " . print_r(func_get_args(), true));
        $sql = "INSERT INTO [tblCardGroup] (CardGroupID,CardGroupName,Description,CardType,VehicleGroupID,ValidTimeStart,ValidTimeEnd,Formulation,FreeTime,IsHaveMoneyExcessTime,EnableFree,DayTimeFrom,DayTimeTo,EachFee,RestrictedNumber,IsCheckPlate,IsHaveMoneyExpiredDate,Inactive,IsSpecialGroup,isLockingCharge,LaneIDs ,Block0,Time0,Block1 ,Time1,Block2,Time2,Block3,Time3,Block4,Time4,Block5,Time5, TimePeriods, Costs) VALUES (NEWID(),:CardGroupName,:Description,:CardType,:VehicleGroupID,:ValidTimeStart,:ValidTimeEnd,:Formulation,:FreeTime,:IsHaveMoneyExcessTime,:EnableFree,:DayTimeFrom,:DayTimeTo,:EachFee,:RestrictedNumber,:IsCheckPlate,:IsHaveMoneyExpiredDate,:Inactive,:IsSpecialGroup,:isLockingCharge, :LaneIDs,:Block0, :Time0, :Block1 ,:Time1, :Block2, :Time2, :Block3, :Time3, :Block4, :Time4, :Block5, :Time5,:TimePeriods, :Costs)";
      
        $db = Database::getInstance();
        $stmt = $db->prepare($sql);
        try {
            
            $stmt->execute([
            'CardGroupName' => $CardGroupName,
            'Description' => $Description,
            'CardType' => $CardType,
            'VehicleGroupID' => $VehicleGroupID,
            'ValidTimeStart' => $ValidTimeStart,
            'ValidTimeEnd' => $ValidTimeEnd,
            'Formulation' => $Formulation,
            'FreeTime' => $FreeTime,
            'IsHaveMoneyExcessTime' => $IsHaveMoneyExcessTime,
            'EnableFree' => $EnableFree,
            'DayTimeFrom' => $DayTimeFrom,
            'DayTimeTo' => $DayTimeTo,
            'EachFee' => $EachFee,
            'RestrictedNumber' => $RestrictedNumber,
            'IsCheckPlate' => $IsCheckPlate,
            'IsHaveMoneyExpiredDate' => $IsHaveMoneyExpiredDate,
            'Inactive' => $Inactive,
            'IsSpecialGroup' => $IsSpecialGroup,
            'isLockingCharge' => $isLockingCharge,
            'LaneIDs' => $LaneIDs,
            'Block0' => $Block0,
            'Time0' => $Time0,
            'Block1' => $Block1,
            'Time1' => $Time1,
            'Block2' => $Block2,
            'Time2' => $Time2,
            'Block3' => $Block3,
            'Time3' => $Time3,
            'Block4' => $Block4,
            'Time4' => $Time4,
            'Block5' => $Block5,
            'Time5' => $Time5,
            'TimePeriods' => $TimePeriods,
            'Costs' => $Costs
           
        ]);
        } catch (\Exception $e) {
            error_log("SQL Error: " . $e->getMessage());
            throw $e;
        }
        
     }

     public static function findCardGroupByID($CardGroupID)
     {
        $sql = "SELECT * FROM [tblCardGroup] WHERE CardGroupID = :CardGroupID";
         $db = Database::getInstance();
         $stmt = $db->prepare($sql);
         $stmt->execute(['CardGroupID' => $CardGroupID]);
         return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     public static function softDeleteCardGroup($CardGroupID){

        $sql = "UPDATE [tblCardGroup] SET Inactive = 1 WHERE CardGroupID = :CardGroupID";
         $db = Database::getInstance();
         $stmt = $db->prepare($sql);
         $stmt->execute(['CardGroupID' => $CardGroupID]);
        return $stmt->rowCount() > 0; // Return true if the update was successful
        
     }

     public static function updateCardCategory(
            $CardGroupID,
         $CardGroupName,
         $Description,
         $CardType,
         
         $VehicleGroupID,
         $ValidTimeStart,
         $ValidTimeEnd,
         $Formulation,
         $FreeTime,
         $IsHaveMoneyExcessTime,
         $EnableFree,
         $DayTimeFrom,
         $DayTimeTo,
         $EachFee,
         $SortOrder,
        $RestrictedNumber,
         $IsCheckPlate,
         $IsHaveMoneyExpiredDate,
         $Inactive,
         $IsSpecialGroup,
         $isLockingCharge,
         $LaneIDs ,
         $Block0, 
         $Time0, 
         $Block1 , 
         $Time1, 
         $Block2, 
         $Time2, 
         $Block3, 
         $Time3, 
         $Block4, 
         $Time4, 
         $Block5, 
         $Time5,
         $TimePeriods,
        $Costs
     )
     {
        error_log("Params in updateCardCategory: " . print_r(func_get_args(), true));
        // Prepare the SQL statement
        $sql = "UPDATE [tblCardGroup] SET CardGroupName = :CardGroupName, Description = :Description, CardType = :CardType, VehicleGroupID = :VehicleGroupID, ValidTimeStart = :ValidTimeStart, ValidTimeEnd = :ValidTimeEnd, Formulation = :Formulation, FreeTime = :FreeTime, IsHaveMoneyExcessTime = :IsHaveMoneyExcessTime, EnableFree = :EnableFree, DayTimeFrom = :DayTimeFrom, DayTimeTo = :DayTimeTo, EachFee = :EachFee, RestrictedNumber = :RestrictedNumber, IsCheckPlate = :IsCheckPlate, IsHaveMoneyExpiredDate = :IsHaveMoneyExpiredDate, Inactive = :Inactive, IsSpecialGroup = :IsSpecialGroup,isLockingCharge=:isLockingCharge,LaneIDs=:LaneIDs , Block0=:Block0 , Time0=:Time0 , Block1=:Block1 , Time1=:Time1 , Block2=:Block2 , Time2=:Time2 , Block3=:Block3 , Time3=:Time3 , Block4=:Block4 , Time4=:Time4 , Block5=:Block5 , Time5=:Time5 , TimePeriods=:TimePeriods, Costs=:Costs WHERE CardGroupID = :CardGroupID";
        $db = Database::getInstance();      
        $stmt = $db->prepare($sql);
        try {
            $stmt->execute([
                'CardGroupID' => $CardGroupID,
                'CardGroupName' => $CardGroupName,
                'Description' => $Description,
                'CardType' => $CardType,
                'VehicleGroupID' => $VehicleGroupID,
                'ValidTimeStart' => $ValidTimeStart,
                'ValidTimeEnd' => $ValidTimeEnd,
                'Formulation' => $Formulation,
                'FreeTime' => $FreeTime,
                'IsHaveMoneyExcessTime' => $IsHaveMoneyExcessTime,
                'EnableFree' => $EnableFree,
                'DayTimeFrom' => $DayTimeFrom,
                'DayTimeTo' => $DayTimeTo,
                'EachFee' => $EachFee,
                'RestrictedNumber' => $RestrictedNumber,
                'IsCheckPlate' => $IsCheckPlate,
                'IsHaveMoneyExpiredDate' => $IsHaveMoneyExpiredDate,
                'Inactive' => $Inactive,
                'IsSpecialGroup' => $IsSpecialGroup,
                'isLockingCharge' => $isLockingCharge,
                'LaneIDs' => $LaneIDs ,
                'Block0' => $Block0, 
                'Time0' => $Time0, 
                'Block1' => $Block1 , 
                'Time1' => $Time1, 
                'Block2' => $Block2, 
                'Time2' => $Time2, 
                'Block3' => $Block3, 
                'Time3' => $Time3, 
                'Block4' => $Block4, 
                'Time4' => $Time4, 
                'Block5' => $Block5, 
                'Time5'=>  $Time5,
                 'TimePeriods'=>  $TimePeriods,
                 'Costs'=>  $Costs
            ]);
        } catch (\Exception $e) {
            error_log("SQL Error: " . $e->getMessage());
            throw new \Exception("Error updating card category: " . $e->getMessage());
        }

    }
}
