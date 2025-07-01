<?php
namespace App\helpers;

use App\Models\CardProcess;
use App\Services\Database;
use \Exception;
use \PDOException;
use PDO;

class CardProcessLogger
{
    public static function logAction($cardId, $action, $userId, $description = null, $cardData = null)
    {

        error_log("[CARD PROCESS LOG] logAction CALLED with cardId=$cardId, action=$action, userId=$userId, description=$description");
        try {
            $card = $cardData ?: self::getCardById($cardId);
            if (!$card) {
                
                return false;
            }

        

            $data = [
                'Date' => date('Y-m-d H:i:s'),
                'CardNumber' => $card['CardNumber'] ?? '',
                'CardGroupID' => $card['CardGroupID'] ?? '',
                'CustomerID' => $card['CustomerID'] ?? '',
                'UserID' => $userId ?? '',
                'Description' => $description ?? '',
                'Plates' => $card['Plate1'] ?? '', 
                'OldInfoCP' => null,
                'Actions' => $action ?? '',
                'AccessLevelID' => $card['AccessLevelID'] ?? '',
            ];

            error_log("[CARD PROCESS LOG] Data to insert: " . json_encode($data));

            $insertResult = CardProcess::insert($data);
            
            
            return $insertResult;
        } catch (PDOException $e) {
            error_log("[CARD PROCESS LOG] PDO Error logging card action: " . $e->getMessage());
          
            return false;
        } 
    }

    private static function getCardById($cardId)
    {

        
        try {
            $pdo = Database::getInstance();
            // Sửa query để sử dụng dấu ngoặc vuông như trong CardManager
            $stmt = $pdo->prepare("SELECT * FROM [tblCard] WHERE CardID = ?");
            $stmt->execute([$cardId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            
            return $result;
        } catch (PDOException $e) {
            error_log("[CARD PROCESS LOG] Error fetching card by ID: " . $e->getMessage());

            return null;
        }
    }
}


?>