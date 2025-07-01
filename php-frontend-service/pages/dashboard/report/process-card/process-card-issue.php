<?php 
    include_once __DIR__ . '/../../../../api/request.php';

    $from = $_GET['from'] ?? null;
    $to = $_GET['to'] ?? null;
    $paramQuerys = http_build_query([
        'from' => $from,
        'to' => $to,
        
    ]);

    $apiUrl = 'http://localhost:8000/api/report/process-card-issue?'. $paramQuerys;

    $response = apiRequest('GET', $apiUrl);
    error_log('Response từ API: ' . $response);
    $cardProcessIssues = json_decode($response, true);
    error_log('Card Process Issues: ' . print_r($cardProcessIssues, true));

    
    
?>

<style>
.table {
    font-size: 13px !important;
}
.filter-label {
    font-weight: bold;
}
</style>

<div class="container ">
    <h4 class="mb-4">Tổng hợp xử lí thẻ</h4>

    <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="row g-3 mb-3 align-items-end">
       <input type="hidden" name="page" value="<?php echo htmlspecialchars($_GET['page'] ?? 'process-card-detail'); ?>">
      

        <div class="col-md-3">
            <label for="from" class="filter-label">Từ ngày:</label>
            <input type="date" name="from" class="form-control" value="<?= $_GET['from'] ?? '' ?>">
        </div>

        <div class="col-md-3">
            <label for="to" class="filter-label">Đến ngày:</label>
            <input type="date" name="to" class="form-control" value="<?= $_GET['to'] ?? '' ?>">
        </div>
       

        <div class="col-md-2 d-flex justify-content-end gap-2">
            <button type="submit" id="reloadButton" class="btn btn-secondary">Nạp lại</button>
            <button type="submit" id="searchButton" class="btn btn-primary"><i class="bi bi-search"></i> Tìm kiếm</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Nhóm thẻ</th>
                    <th>Thêm thẻ</th>
                    <th>Phát thẻ</th>
                    <th>Kích hoạt thẻ</th>
                    <th>Khoá thẻ</th>
                    <th>Mở thẻ</th>
                    <th>Xoá thẻ</th>

                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; ?>
                <?php foreach ($cardProcessIssues as $key => $cardProcessIssue): ?></td>
                
                    <tr>
                        <td><?= $stt++ ?></td>
                        <td><?= htmlspecialchars($cardProcessIssue['CardGroupName']) ?></td>
                        <td><?= $cardProcessIssue['countAddCard'] ?></td>
                        <td><?= $cardProcessIssue['countReleaseCard'] ?></td>
                        <td><?= $cardProcessIssue['countActiveCard'] ?></td>
                        <td><?= $cardProcessIssue['countLockCard'] ?></td>
                        <td><?= $cardProcessIssue['countUnlockCard'] ?></td>
                        <td><?= $cardProcessIssue['countDeleteCard'] ?></td>
                      
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(event) {
    console.log('Form submitted with values:');
    const formData = new FormData(this);
    for (const [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }
});
</script>
