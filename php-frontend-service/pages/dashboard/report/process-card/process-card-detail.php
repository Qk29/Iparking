<?php 
    include_once __DIR__ . '/../../../../api/request.php';

    $cardCategoryApiUrl = 'http://localhost:8000/api/category/card-category';
    $cardCategoryResponse = apiRequest('GET', $cardCategoryApiUrl);
    $cardCategories = json_decode($cardCategoryResponse, true);

    $customerGroupApiUrl = 'http://localhost:8000/api/category/customer-group';
    $customerGroupResponse = apiRequest('GET', $customerGroupApiUrl);
    $customerGroups = json_decode($customerGroupResponse, true);

    $userApiUrl = 'http://localhost:8000/api/system/users';
    $userResponse = apiRequest('GET', $userApiUrl);
    $users = json_decode($userResponse, true);


    $allowedKeys = ['action', 'from', 'to', 'search', 'customerSelect', 'cardGroupSelect', 'userSelect'];
    $queryParams = [];

    error_log("Raw GET params: " . print_r($_GET, true));

    foreach ($allowedKeys as $key) {
    if (isset($_GET[$key]) && $_GET[$key] !== '') {
        $queryParams[$key] = $_GET[$key];
    }
}
    


    $apiUrl = 'http://localhost:8000/api/report/card-process-detail?' . (http_build_query($queryParams));
    error_log('API gọi đến: ' . $apiUrl);
    $response = apiRequest('GET', $apiUrl);
    $cardProcessDetails = json_decode($response, true);

    
    
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
    <h4 class="mb-4">Chi tiết xử lý thẻ</h4>

    <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="row g-3 mb-3 align-items-end">
       <input type="hidden" name="page" value="<?php echo htmlspecialchars($_GET['page'] ?? 'process-card-detail'); ?>">
        <div class="col-md-3">
            <label for="searchInput" class="filter-label">Số thẻ:</label>
            <input id="searchInput" name="search" type="text" class="form-control" placeholder="Nhập số thẻ">
        </div>

        <div class="col-md-3">
            <label for="customerSelect" class="filter-label">Nhóm khách hàng:</label>
            <select class="form-select" id="customerSelect" name="customerSelect">
                <option value="">-- Chọn nhóm --</option>
                <?php foreach ($customerGroups as $group): ?>
                    <option value="<?= $group['CustomerGroupID'] ?>"><?= $group['CustomerGroupName'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label for="cardGroupSelect" class="filter-label">Nhóm thẻ:</label>
            <select class="form-select" id="cardGroupSelect" name="cardGroupSelect">
                <option value="">-- Chọn nhóm --</option>
                <?php foreach ($cardCategories as $cardCate): ?>
                    <option value="<?= $cardCate['CardGroupID'] ?>"><?= $cardCate['CardGroupName'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label for="action" class="filter-label">Hành động:</label>
            <select name="action" class="form-select">
                <option value="">-- Chọn thao tác --</option>
                <option value="ADD">Thêm thẻ</option>
                <option value="RELEASE">Phát thẻ</option>
                <option value="DELETE">Xóa thẻ</option>
                <option value="LOCK">Khóa thẻ</option>
                <option value="UNLOCK">Mở thẻ</option>
                <option value="ACTIVE">Kích hoạt thẻ</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="from" class="filter-label">Từ ngày:</label>
            <input type="date" name="from" class="form-control" value="<?= $_GET['from'] ?? '' ?>">
        </div>

        <div class="col-md-3">
            <label for="to" class="filter-label">Đến ngày:</label>
            <input type="date" name="to" class="form-control" value="<?= $_GET['to'] ?? '' ?>">
        </div>
        <div class="col-md-3">
            <label for="to" class="filter-label">Người dùng</label>
            <select class="form-select" id="userSelect" name="userSelect">
                <option value="">-- Người dùng --</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['Id'] ?>"><?= $user['Username'] ?></option>
                <?php endforeach; ?>
            </select>
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
                    <th>Thời gian</th>
                    <th>Card No</th>
                    <th>Mã thẻ</th>
                    <th>Nhóm thẻ</th>
                    <th>Thao tác</th>
                    <th>Chủ thẻ</th>
                    <th>Nhóm khách hàng</th>
                    <th>Đại chỉ</th>
                    <th>Biển số</th>
                    <th>Nhân viên xử lý</th>
                    <th>Thông tin cũ</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($cardProcessDetails)): ?>
            <?php $i = 1; ?>
            <?php foreach ($cardProcessDetails as $index => $item): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $item['Date'] ?? '' ?></td>
                <td><?= $item['CardNumber'] ?? '' ?></td>
                <td><?= $item['CardID'] ?? '' ?></td>
                <td><?= $item['CardGroupName'] ?? '' ?></td>
                <td><?= $item['Actions'] ?? '' ?></td>
                <td><?= $item['CustomerName'] ?? '' ?></td>
                <td><?= $item['CustomerGroupName'] ?? '' ?></td>
                <td><?= $item['Address'] ?? '' ?></td>
                <td><?= $item['Plates'] ?? '' ?></td>
                <td><?= $item['Username'] ?? '' ?></td>
                <td><?= $item['OldInfoCP'] ?? '' ?></td>
            </tr>
        <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="11">Không có dữ liệu</td></tr>
        <?php endif; ?>
        
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
