<?php 

include_once __DIR__ . '/../../api/request.php';

$vehiclesIn = null;
$vehiclesOut = null;
$errorMessage = null;

if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $apiUrl = 'http://localhost:8000/api/system/event-cards'; // Cập nhật lại URL đúng với route trong Slim

    // Format the dates properly
    $fromDate = str_replace('T', ' ', $_GET['from_date']) . ':00';
    $toDate = str_replace('T', ' ', $_GET['to_date']) . ':00';

     $params = [
        'from_date' => $fromDate,
        'to_date' => $toDate
    ];
    // Gọi API kiểu GET với query string
    $query = http_build_query($params);
    $fullUrl = $apiUrl . '?' . $query;

    $token = $_SESSION['token'] ?? null;

    try {
    $result = apiRequest('GET', $fullUrl, null, $token);
    
        
        // For debugging - comment this out in production
        // echo "<pre>API Response: " . htmlspecialchars($result) . "</pre>";
        
        $responseData = json_decode($result, true);
        
        if ($responseData && isset($responseData['success']) && $responseData['success'] === true) {
            $vehiclesIn = $responseData['data']['vehicles_in'] ?? 0;
            $vehiclesOut = $responseData['data']['vehicles_out'] ?? 0;
        } else {
            $errorMessage = "Lỗi: " . ($responseData['message'] ?? 'Không thể xử lý phản hồi từ API.');
        }
        } catch (Exception $e) {
            $errorMessage = "Lỗi kết nối đến API: " . $e->getMessage();
        }
    
}
?>
<h2 class="mb-4">Bàn làm việc</h2>

<form method="GET" action="index.php?page=event-card" class="row g-3 align-items-end">
    <input type="hidden" name="page" value="event-card">
    
    <div class="col-md-4">
        <label for="from_date" class="form-label">Từ ngày:</label>
        <input type="datetime-local" name="from_date" id="from_date" class="form-control" value="<?= $_GET['from_date'] ?? '' ?>" required>
    </div>

    <div class="col-md-4">
        <label for="to_date" class="form-label">Đến ngày:</label>
        <input type="datetime-local" name="to_date" id="to_date" class="form-control" value="<?= $_GET['to_date'] ?? '' ?>" required>
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
    </div>
</form>

<?php if ($errorMessage): ?>
    <div class="alert alert-danger mt-4" role="alert">
        <?= htmlspecialchars($errorMessage) ?>
    </div>
<?php endif; ?>

<?php if (isset($vehiclesIn) && isset($vehiclesOut)): ?>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="text-white card-title fs-4">Xe vào</h5>
                    <p class="card-text fs-4"><?= $vehiclesIn ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="text-white card-title fs-4">Xe ra</h5>
                    <p class="card-text fs-4"><?= $vehiclesOut ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
