<?php 
include_once __DIR__ . '/../../api/request.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');

$vehiclesIn = null;
$vehiclesOut = null;
$errorMessage = null;
$currentDate = date('Y-m-d\TH:i');

// Lấy từ URL   
$pageNumIn = isset($_GET['page_num_in']) ? (int)$_GET['page_num_in'] : 1;
$pageNumOut = isset($_GET['page_num_out']) ? (int)$_GET['page_num_out'] : 1;
$limit = 20;
$offsetIn = ($pageNumIn - 1) * $limit;
$offsetOut = ($pageNumOut - 1) * $limit;

if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $apiUrl = 'http://localhost:8000/api/card-event/event-cards';

    $fromDate = str_replace('T', ' ', $_GET['from_date']) . ':00';
    $toDate = str_replace('T', ' ', $_GET['to_date']) . ':00';

    $paramsIn = [
        'from_date' => $fromDate,
        'to_date' => $toDate,
        'offset' => $offsetIn,
        'limit' => $limit
    ];

    $query = http_build_query($paramsIn);
    $urlIn = $apiUrl . '?' . $query;

    $token = $_SESSION['token'] ?? null;

    try {
        $result = apiRequest('GET', $urlIn, null, $token);
        // echo "<pre>API Response: " . htmlspecialchars($result) . "</pre>"; // Debug nếu cần

        $responseData = json_decode($result, true);

        if ($responseData && isset($responseData['success']) && $responseData['success'] === true) {
            $vehiclesIn = $responseData['data']['vehicles_in'] ?? 0;
            $vehiclesInList = $responseData['data']['vehicles_in_list'] ?? [];
        } else {
            $errorMessage = "Lỗi: " . ($responseData['message'] ?? 'Không thể xử lý phản hồi từ API In.');
        }
    } catch (Exception $e) {
        $errorMessage = "Lỗi kết nối đến API: " . $e->getMessage();
    }

    $paramsIn = [
        'from_date' => $fromDate,
        'to_date' => $toDate,
        'offset' => $offsetOut,
        'limit' => $limit
    ];

    $query = http_build_query($paramsIn);
    $urlOut = $apiUrl . '?' . $query;

    $token = $_SESSION['token'] ?? null;

    try {
        $result = apiRequest('GET', $urlOut, null, $token);
        // echo "<pre>API Response: " . htmlspecialchars($result) . "</pre>"; // Debug nếu cần

        $responseData = json_decode($result, true);

        if ($responseData && isset($responseData['success']) && $responseData['success'] === true) {
            $vehiclesOut = $responseData['data']['vehicles_out'] ?? 0;
            $vehiclesOutList = $responseData['data']['vehicles_out_list'] ?? [];
        } else {
            $errorMessage = "Lỗi: " . ($responseData['message'] ?? 'Không thể xử lý phản hồi từ API In.');
        }
    } catch (Exception $e) {
        $errorMessage = "Lỗi kết nối đến API: " . $e->getMessage();
    }
}
?>

<h2 class="mb-4">Bàn làm việc</h2>

<form method="GET" action="index.php" class="row g-3 align-items-end">
    <input type="hidden" name="page" value="event-card">

    <div class="col-md-4">
        <label for="from_date" class="form-label">Từ ngày:</label>
        <input type="datetime-local" name="from_date" id="from_date" class="form-control" value="<?= $_GET['from_date'] ?? $currentDate ?>" required>
    </div>

    <div class="col-md-4">
        <label for="to_date" class="form-label">Đến ngày:</label>
        <input type="datetime-local" name="to_date" id="to_date" class="form-control" value="<?= $_GET['to_date'] ?? $currentDate ?>" required>
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

    <?php if (!empty($vehiclesInList)): ?>
        <h4>Danh sách xe đang trong bãi</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>CardNumber</th>
                    <th>DatetimeIn</th>
                    <th>PlateIn</th>
             
                  
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehiclesInList as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['CardNumber']) ?></td>
                        <td><?= htmlspecialchars($item['DatetimeIn']) ?></td>
                        <td><?= htmlspecialchars($item['PlateIn']) ?></td>
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        $totalPages = ceil($vehiclesIn / $limit);
        renderSimplePagination($pageNumIn, $totalPages, [
            'page' => 'event-card',
            'from_date' => $_GET['from_date'],
            'to_date' => $_GET['to_date'],
            'type' => 'in',
            'page_num_in' => $pageNumIn
        ]);
        ?>
    <?php endif; ?>

    <?php if (!empty($vehiclesOutList)): ?>
        <h4>Danh sách xe đã ra khỏi bãi</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>CardNumber</th>
                    <th>DatetimeIn</th>
                    <th>DatetimeOut</th>
                    <th>PlateIn</th>
                    <th>PlateOut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehiclesOutList as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['CardNumber']) ?></td>
                        <td><?= htmlspecialchars($item['DatetimeIn']) ?></td>
                        <td><?= htmlspecialchars($item['DateTimeOut']) ?></td>
                        <td><?= htmlspecialchars($item['PlateIn']) ?></td>
                        <td><?= htmlspecialchars($item['PlateOut']) ?></td>
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        $totalPages = ceil($vehiclesOut / $limit);
        renderSimplePagination($pageNumOut, $totalPages, [
            'page' => 'event-card',
            'from_date' => $_GET['from_date'],
            'to_date' => $_GET['to_date'],
            'type' => 'out',
            'page_num_out' => $pageNumOut
        ]);
        ?>
    <?php endif; ?>
<?php endif; ?>

<?php
function renderSimplePagination($pageNum, $totalPages, $baseParams) {
    if ($totalPages <= 1) return;

    $type = $baseParams['type'] ?? 'in';
    $paramName = $type === 'out' ? 'page_num_out' : 'page_num_in';

    echo '<div class="pagination mt-3">';

    // Previous
    if ($pageNum > 1) {
        $baseParams[$paramName] = $pageNum - 1;
        echo '<a class="btn btn-sm btn-outline-secondary me-1" href="index.php?' . http_build_query($baseParams) . '">Previous</a>';
    }

    // Trang đầu
    $baseParams[$paramName] = 1;
    echo '<a class="btn btn-sm ' . ($pageNum == 1 ? 'btn-primary' : 'btn-outline-primary') . ' me-1" href="index.php?' . http_build_query($baseParams) . '">1</a>';

    if ($pageNum > 3) {
        echo '<span class="btn btn-sm btn-light disabled me-1">...</span>';
    }

    for ($i = max(2, $pageNum - 1); $i <= min($totalPages - 1, $pageNum + 1); $i++) {
        $baseParams[$paramName] = $i;
        echo '<a class="btn btn-sm ' . ($pageNum == $i ? 'btn-primary' : 'btn-outline-primary') . ' me-1" href="index.php?' . http_build_query($baseParams) . '">' . $i . '</a>';
    }

    if ($pageNum < $totalPages - 2) {
        echo '<span class="btn btn-sm btn-light disabled me-1">...</span>';
    }

    if ($totalPages > 1) {
        $baseParams[$paramName] = $totalPages;
        echo '<a class="btn btn-sm ' . ($pageNum == $totalPages ? 'btn-primary' : 'btn-outline-primary') . ' me-1" href="index.php?' . http_build_query($baseParams) . '">' . $totalPages . '</a>';
    }

    if ($pageNum < $totalPages) {
        $baseParams[$paramName] = $pageNum + 1;
        echo '<a class="btn btn-sm btn-outline-secondary ms-1" href="index.php?' . http_build_query($baseParams) . '">Next</a>';
    }

    echo '</div>';
}

?>



