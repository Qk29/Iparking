<?php 
    include_once __DIR__ . '/../../../../api/request.php';

    $currentDate = date('Y-m-d\TH:i');

    //call api get-customer-group
    $customerGroupApiUrl = 'http://localhost:8000/api/category/customer-group';
    $customerGroupResponse = apiRequest('GET', $customerGroupApiUrl);
    $customerGroups = json_decode($customerGroupResponse, true);

    // call api get-lane
    $getLanesUrl  = 'http://localhost:8000/api/lane/get-all';
    $laneResponse  = apiRequest('GET', $getLanesUrl );
    $lanes  = json_decode($laneResponse, true);

    // call api get-card-category
    $cardCategoryApiUrl = 'http://localhost:8000/api/category/card-category';
    $cardCategoryResponse = apiRequest('GET', $cardCategoryApiUrl);
    $cardCategories = json_decode($cardCategoryResponse, true);

    // Check if the request method is POST
    $customer_group = $_POST['customer_group'] ?? null;
    $card_group = $_POST['card_group'] ?? null;
    $lane = $_POST['lane'] ?? null;

    $filters = [
      'from_date' => $_POST['from_date'] ?? null,
      'to_date' => $_POST['to_date'] ?? null,
      'customer_group' => !empty($_POST['customer_group']) ? $_POST['customer_group'] : null,
      'card_group' => !empty($_POST['card_group']) ? $_POST['card_group'] : null,
      'lane' => !empty($_POST['lane']) ? $_POST['lane'] : null,
      'keyword' => $_POST['keyword'] ?? null,
  ];

    $queryString = http_build_query(array_filter($filters)); // bỏ các giá trị null



    // call api get vehicle in
    $getVehicleInUrl = 'http://localhost:8000/api/card-event/vehicle-in?' . $queryString;
    $vehicleInResponse = apiRequest('POST', $getVehicleInUrl);
    $vehicleInData = json_decode($vehicleInResponse, true);
    // error_log("Vehicle In Data: " . print_r($vehicleInData, true));
        

    
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
  <h5 class="mb-3 mt-3">Xe trong bãi hiện tại ()</h5>

  <!-- Bộ lọc tìm kiếm -->
  <div class="bg-white p-3 border rounded mb-4">
    <form method="POST" class="row g-3 align-items-end">
      <div class="col-md-3">
        <label class="form-label">Từ khóa</label>
        <input type="text" name="keyword" class="form-control" placeholder="Mã thẻ, Biển số...">
      </div>

      <div class="col-md-3">
        <label class="form-label">Nhóm khách hàng</label>
        <select name="customer_group" class="form-select">
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
        <label class="form-label">Làn</label>
        <select name="lane" class="form-select">
          <option value="" selected>-- Lane --</option>
          <?php foreach($lanes as $lane) : ?>
            <option value="<?= $lane['LaneID'] ?>"><?= $lane['LaneName'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Nhóm thẻ</label>
        <select name="card_group" class="form-select">
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
          <th>Người dùng</th>
          <th>Làn vào</th>
          <th>Giám sát vào</th>
          <th>Ngày hết hạn</th>
          <th>Thời gian còn lại</th>
          <th>Phí gửi xe</th>
          <th>Xử lý</th>
        </tr>
      </thead>
      <tbody class="text-center">
            
            <?php $stt = 1; foreach ($vehicleInData['data'] as $vehicle): ?>
              <tr>
                <td><?= $stt++ ?></td>
                <td><?= $vehicle['CardNo'] ?></td>
                <td><?= $vehicle['CardNumber'] ?></td>
                <td><?= $vehicle['IsPlateInValid'] == 1 ? '✔️' : '❌' ?></td>
                <td><?= $vehicle['PlateIn'] ?></td>
                <td><?= $vehicle['DatetimeIn'] ?></td>
                <td><img src="<?= $vehicle['PicDirIn'] ?>" width="70" /></td>
                
                <td></td>
                <td><?= $vehicle['CustomerName'] ?></td>
                <td></td>
                <td><?= $vehicle['Username'] ?? '-' ?></td>
                <td><?= $vehicle['ExpireDate'] ?? '-' ?></td>
                <td><?= $vehicle['RemainTime'] ?? '-' ?></td>
                <td><?= $vehicle['ParkingFee'] ?? '0' ?>đ</td>
                <td>...</td>
              </tr>
            <?php endforeach; ?>
          
      </tbody>
    </table>
  </div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>



$(document).ready(function(){


    $('#reloadButton').on('click', function() {
    $('form')[0].reset(); // reset giá trị trong form
    $('form').submit();   // gửi lại form với method POST (đã clear)
});
});
</script> -->