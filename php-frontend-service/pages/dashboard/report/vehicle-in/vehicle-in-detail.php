<?php 
    include_once __DIR__ . '/../../../../api/request.php';
    //call api get-customer-group
    $customerGroupApiUrl = 'http://localhost:8000/api/category/customer-group';
    $customerGroupResponse = apiRequest('GET', $customerGroupApiUrl);
    $customerGroups = json_decode($customerGroupResponse, true);

    //call api get-vehicle-group
    $getVehicleGroupUrl  = 'http://localhost:8000/api/vehicle-group/get-all';
    $vehicleGroupResponse  = apiRequest('GET', $getVehicleGroupUrl );
    $vehicleGroups  = json_decode($vehicleGroupResponse, true);
    

    // call api get-card-category
    $cardCategoryApiUrl = 'http://localhost:8000/api/category/card-category';
    $cardCategoryResponse = apiRequest('GET', $cardCategoryApiUrl);
    $cardCategories = json_decode($cardCategoryResponse, true);

       
    
    

    //call api get vihicle in
    $queryParams = [];
    // Xử lý time_search
    if (!empty($_GET['time_search'])) {
        $time_search = str_replace('T', ' ', $_GET['time_search']);
    } else {
        $time_search = date('Y-m-d H:i');
    }
    $queryParams['time_search'] = $time_search;

    // Xử lý các select
    if (!empty($_GET['custumerGroup']) && $_GET['custumerGroup'] !== '--Chọn nhóm khách hàng--') {
        $queryParams['custumerGroup'] = $_GET['custumerGroup'];
    }
    if (!empty($_GET['vehicleGroup']) && $_GET['vehicleGroup'] !== '--Chọn nhóm phương tiện--') {
        $queryParams['vehicleGroup'] = $_GET['vehicleGroup'];
    }
    if (!empty($_GET['card_group']) && $_GET['card_group'] !== '--Chọn nhóm thẻ--') {
        $queryParams['card_group'] = $_GET['card_group'];
    }
    $queryParams['keyword'] = $_GET['keyword'] ?? '';
    
    
    $getVehicleInUrl = 'http://localhost:8000/api/card-event/get-vehicle-in?' . http_build_query($queryParams);
    $getVehicleInResponse = apiRequest('GET', $getVehicleInUrl);
    $vehicleIns = json_decode($getVehicleInResponse, true);
    
   
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
      <li class="breadcrumb-item active" aria-current="page">Chi tiết xe trong bãi tại thời điểm bất kỳ</li>
    </ol>
  </nav>

  <!-- Title -->
  <h5 class="mb-3 mt-3">Chi tiết xe trong bãi tại thời điểm bất kỳ (<?= count($vehicleIns) ?>)</h5>

  <!-- Bộ lọc tìm kiếm -->
  <div class="bg-white p-3 border rounded mb-4">
    <form method="GET" action="index.php"  class="row g-3 align-items-end">
      <input type="hidden" name="page" value="car-in-detail">
      <div class="col-md-3">
        <label class="form-label">Từ khóa</label>
        <input type="text" name="keyword" class="form-control" placeholder="Mã thẻ, Biển số...">
      </div>

      <div class="col-md-3">
        <label class="form-label">Thời điểm</label>
        <input type="datetime-local" name="time_search" class="form-control" value="<?= date('Y-m-d\TH:i') ?>">
      </div>

      <div class="col-md-3">
        <label class="form-label">Nhóm khách hàng</label>
        <select name="custumerGroup" class="form-select">
          <option selected>--Chọn nhóm khách hàng--</option>
          <?php if (!empty($customerGroups)) foreach ($customerGroups as $group): ?>
            <option value="<?= $group['CustomerGroupID'] ?>">
              <?= $group['CustomerGroupName'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Nhóm phương tiện</label>
        <select name="vehicleGroup" class="form-select">
          <option selected>--Chọn nhóm phương tiện--</option>
          <?php if (!empty($vehicleGroups)) foreach ($vehicleGroups as $vehicle): ?>
            <option value="<?= $vehicle['VehicleGroupID'] ?>">
              <?= $vehicle['VehicleGroupName'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Nhóm thẻ</label>
        <select name="card_group" class="form-select">
          <option selected>--Chọn nhóm thẻ--</option>
          <?php if (!empty($cardCategories)) foreach ($cardCategories as $card): ?>
            <option value="<?= $card['CardGroupID'] ?>">
              <?= $card['CardGroupName'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3 d-flex align-items-center">
        <button type="submit" class="btn btn-primary me-2">Tìm kiếm</button>
        <button type="reset" class="btn btn-outline-secondary me-2">Reset</button>
        <button type="button" class="btn btn-success">Xuất Excel</button>
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
          <th>Biển số</th>
      
          <th>Thời gian vào</th>
          <th>Hình ảnh vào</th>
          <th>Nhóm thẻ</th>
          <th>Người dùng</th>
          <th>Làn vào</th>


        </tr>
      </thead>
      <tbody class="text-center">

        <?php foreach($vehicleIns as $key => $vehicle): ?>
        <tr>
            <td><?= $key + 1 ?></td>
            <td><?= $vehicle['CardNo'] ?></td>  
            <td><?= $vehicle['CardNumber'] ?></td>
            
            <td><?= $vehicle['PlateIn'] ?></td>
            <td><?= $vehicle['DatetimeIn'] ?></td>
            <td><img src="<?= $vehicle['PicDirIn'] ?>" alt=""></td>
            <td><?= $vehicle['CardGroupName']?></td>
            <td><?= $vehicle['CustomerName'] ?></td>
            <td><?= $vehicle['LaneName'] ?></td>
        </tr>
        <?php endforeach; ?>
        
      </tbody>
    </table>
  </div>
</div>
