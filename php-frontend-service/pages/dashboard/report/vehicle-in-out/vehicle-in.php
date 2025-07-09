<?php

use PHPUnit\Framework\Constraint\Count;

    include_once __DIR__ . '/../../../../api/request.php';

    $currentDate = date('Y-m-d\TH:i');

    //call api get-customer-group
    $customerGroupApiUrl = 'http://localhost:8000/api/category/customer-group';
    $customerGroupResponse = apiRequest('GET', $customerGroupApiUrl);
    $customerGroups = json_decode($customerGroupResponse, true);

    // call api get-card-category
    $cardCategoryApiUrl = 'http://localhost:8000/api/category/card-category';
    $cardCategoryResponse = apiRequest('GET', $cardCategoryApiUrl);
    $cardCategories = json_decode($cardCategoryResponse, true);

    

    

    $allowedKeys = ['search', 'customerSelect', 'cardGroupSelect', 'from_date', 'to_date'];
    $queryParams = [];

    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
    $queryParams['offset'] = $offset;
    $queryParams['limit'] = $limit;

    // error_log("Raw POST params: " . print_r($_POST, true));
    foreach ($allowedKeys as $key) {
        if (isset($_GET[$key]) && $_GET[$key] !== '') {
            $queryParams[$key] = $_GET[$key];
        }
    }




    // call api get vehicle in
    $getVehicleInUrl = 'http://localhost:8000/api/report/vehicle-in?' . http_build_query($queryParams);
    $vehicleInResponse = apiRequest('GET', $getVehicleInUrl);
    error_log("Response from API: " . $vehicleInResponse);
    $vehicleInData = json_decode($vehicleInResponse, true);
    error_log("Vehicle In Data: " . print_r($vehicleInData, true));

    $currentPage = floor($offset / $limit) + 1;
    $nextOffset = $offset + $limit;
    $prevOffset = max(0, $offset - $limit);
    $totalCurrent = isset($vehicleInData['data']) && is_array($vehicleInData['data']) ? count($vehicleInData['data']) : 0;
?>
<style>
    .table {
    font-size: 12px !important;
}
</style>

<div class="container-fluid px-3">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mt-3">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i> Trang chủ</a></li>
      <li class="breadcrumb-item"><a href="#">Web</a></li>
      <li class="breadcrumb-item"><a href="#">Báo cáo</a></li>
      <li class="breadcrumb-item"><a href="#">Xe trong bãi</a></li>
      <li class="breadcrumb-item active" aria-current="page">Xe trong bãi hiện tại</li>
    </ol>
  </nav>

  <!-- Title -->
  <h5 class="mb-3 mt-3">Báo cáo xe vào (<?= Count($vehicleInData['data']) ?>)</h5>

  <!-- Bộ lọc tìm kiếm -->
  <div class="bg-white p-3 border rounded mb-4">
    <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="row g-3 align-items-end">
        <input type="hidden" name="page" value="<?php echo htmlspecialchars($_GET['page'] ?? 'xe-vao'); ?>">
      <div class="col-md-3">
        <label class="form-label">Từ khóa</label>
        <input type="text" name="search" class="form-control" placeholder="Mã thẻ, Biển số...">
      </div>

      <div class="col-md-3">
        <label class="form-label">Nhóm khách hàng</label>
        <select name="customerSelect" class="form-select">
          <option value="" selected>--Chọn nhóm khách hàng--</option>
          <?php foreach($customerGroups as $group) : ?>
            <option value="<?= $group['CustomerGroupID'] ?>"><?= $group['CustomerGroupName'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <label for="from_date" class="form-label">Từ ngày:</label>
        <input type="datetime-local" name="from_date" id="from_date" class="form-control" value="<?= $_GET['from_date'] ?? $currentDate ?>" required>
    </div>

    <div class="col-md-3">
        <label for="to_date" class="form-label">Đến ngày:</label>
        <input type="datetime-local" name="to_date" id="to_date" class="form-control" value="<?= $_GET['to_date'] ?? $currentDate ?>" required>
    </div>

      <div class="col-md-3">
        <label class="form-label">Nhóm thẻ</label>
        <select name="cardGroupSelect" class="form-select">
          <option value="" selected>-- Nhóm thẻ --</option>
          <?php foreach($cardCategories as $card) : ?>
            <option value="<?= $card['CardGroupID'] ?>"><?= $card['CardGroupName'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-12 d-flex align-items-center">
        

        <button  class="btn btn-primary me-2">Tìm kiếm</button>
        <button  class="btn btn-outline-secondary me-2">Reset</button>
        <button  class="btn btn-success">Xuất Excel</button>
      </div>
    </form>
  </div>

  <!-- Bảng dữ liệu -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead class="table-light text-center">
        <tr>
          <th>STT</th>
          <th>CardNo</th>
          <th>Mã thẻ</th>
          <th>Biển số hợp lệ</th>
          <th>Biển số</th>
          <th>Thời gian vào</th>
          <th>Ảnh vào</th>
          <th>Nhóm thẻ</th>
          <th>Khách hàng</th>
          <th>Làn vào</th>
          <th>Giám sát vào</th>
        </tr>
      </thead>
      <tbody class="text-center">
            
            <?php $stt = 1; foreach ($vehicleInData['data'] as $vehicle): ?>
              <tr>
                <td><?= $stt++ ?></td>
                <td><?= $vehicle['CardNo'] ?></td>
                <td><?= $vehicle['CardNumber'] ?></td>
                <td>
                    <?php if ($vehicle['IsPlateInValid'] == 1): ?>
                        <span style="color: green; font-weight: bold;">✔️ Hợp lệ</span>
                    <?php else: ?>
                        <span style="color: red; font-weight: bold;">❌ Không hợp lệ</span>
                    <?php endif; ?>
                </td>
                <td><?= $vehicle['PlateIn'] ?></td>
                <td><?= $vehicle['DatetimeIn'] ?></td>
                <td><img src="<?= $vehicle['PicDirIn'] ?>" width="70" /></td>
                <td><?= $vehicle['CardGroupName'] ?></td>
                <td><?= $vehicle['CustomerName'] ?></td>
                <td></td>

              </tr>
            <?php endforeach; ?>
          
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-center align-items-center my-3">
    <?php if ($offset > 0): ?>
        <a class="btn btn-outline-primary me-2"
           href="?<?= http_build_query(array_merge($_GET, ['offset' => $prevOffset, 'limit' => $limit])) ?>">
            Trang trước
        </a>
    <?php endif; ?>
    <span>Trang <?= $currentPage ?></span>
    <?php if ($totalCurrent == $limit): ?>
        <a class="btn btn-outline-primary ms-2"
           href="?<?= http_build_query(array_merge($_GET, ['offset' => $nextOffset, 'limit' => $limit])) ?>">
            Trang sau
        </a>
    <?php endif; ?>
  </div>
</div>
