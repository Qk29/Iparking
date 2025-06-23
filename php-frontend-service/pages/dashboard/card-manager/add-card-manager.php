<?php 
    include_once __DIR__ . '/../../../api/request.php';
    // call api to get customer groups
    $customerGroupApiUrl = 'http://localhost:8000/api/category/customer-group';
    $customerGroupResponse = apiRequest('GET', $customerGroupApiUrl);
    $customerGroups = json_decode($customerGroupResponse, true);

    // call API to get apartment categories

    $apartmentCategoryApiUrl = 'http://localhost:8000/api/category/apartment-category';
    $apartmentCategoryResponse = apiRequest('GET', $apartmentCategoryApiUrl);
    $apartmentCategories = json_decode($apartmentCategoryResponse, true);

    // call API to get card groups

    $cardCategoryApiUrl = 'http://localhost:8000/api/category/card-category';
    $cardCategoryResponse = apiRequest('GET', $cardCategoryApiUrl);
    $cardCategories = json_decode($cardCategoryResponse, true);
    
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        error_log("==> Form đã được submit");

        // Customer information

        $customerData = [
        "CustomerGroupID" => $_POST['CustomerGroupID'],
        "CustomerCode" => $_POST['CustomerCode'],
        "CustomerName" => $_POST['CustomerName'],
        "Mobile" => $_POST['Mobile'],
        "Address" => $_POST['Address'],
        "CompartmentID" => $_POST['CompartmentID'],
        "IDNumber" => $_POST['IDNumber'],
        'EnableAccount' => 1,
        "Account" =>  '',
        ];

        $customerAddApiUrl = 'http://localhost:8000/api/customer-manager/add-customer';
        $customerResponse = apiRequest('POST', $customerAddApiUrl, $customerData);
        error_log("response API: " . print_r($customerResponse, true));
        $customerResult = json_decode($customerResponse, true);

        if (!$customerResult) {
            error_log("LỖI: Không nhận được phản hồi JSON hợp lệ từ API khi thêm khách hàng");
        }

        if(isset($customerResult['status']) && $customerResult['status'] === 'success') {
            // Lấy ID của khách hàng vừa tạo
            error_log("==> Thêm khách hàng thành công");
            $customerId = $customerResult['data']['CustomerID'];

             $cardData = [
                "CardNo" => $_POST['CardNo'] ?? '',
                "CardGroupID" => $_POST['CardGroupID'] ?? '',
                "Description" => $_POST['Description'] ?? '', // Đã đồng bộ thành Description
                "CardNumber" => $_POST['CardNumber'] ?? '',
                "DateRegister" => $_POST['DateRegister'] ?? null,
                "DateRelease" => $_POST['DateRelease'] ?? null,
                "ImportDate" => $_POST['ImportDate'] ?? null,
                "ExpireDate" => $_POST['ExpireDate'] ?? null,
                "IsLock" => isset($_POST['IsLock']) ? 1 : 0,
                "Plate1" => $_POST['Plate1'] ?? null,
                "Plate2" => $_POST['Plate2'] ?? null,
                "Plate3" => $_POST['Plate3'] ?? null,
                "VehicleName1" => $_POST['VehicleName1'] ?? null,
                "VehicleName2" => $_POST['VehicleName2'] ?? null,
                "VehicleName3" => $_POST['VehicleName3'] ?? null,
                "CustomerID" => $customerId,
            ];

       error_log("Dữ liệu thẻ được gửi: " . print_r($cardData, true));

        $cardAddApiUrl = 'http://localhost:8000/api/card-manager/add-card';
        $cardResponse = apiRequest('POST', $cardAddApiUrl, $cardData);
        error_log("Dữ liệu thẻ được gửi: " . print_r($cardData, true));
        
        $cardResult = json_decode($cardResponse, true);
        error_log("Kết quả thêm thẻ: " . print_r($cardResult, true));   
        if(isset($cardResult['status']) && $cardResult['status'] === 'success') {
            echo "<div class='alert alert-success'>Thêm khách hàng và thẻ thành công!</div>";
            echo "<script>window.location.href = 'index.php?page=card-customer-manager';</script>";
            exit;
        } else {
            echo "<div class='alert alert-danger'>Thêm khách hàng thất bại!</div>";
            exit;
        }
        
    }
         

        

        // Process the data as needed, e.g., save to database
    }


?>


 <div class="container">
    <h2>Thêm mới thẻ</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <!-- Thống tin thẻ -->
    <div class="card mt-4">
      <div class="card-header bg-success text-white">Thông tin thẻ</div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group required">
              <label>Số thẻ</label>
              <input type="text" name="CardNo" class="form-control" placeholder="Số thẻ">
            </div>
            <div class="form-group required">
              <label>Nhóm thẻ</label>
              <select name="CardGroupID" class="form-control">
                <option>-Chọn nhóm thẻ-</option>
                    <?php foreach ($cardCategories as $cardCategory): ?>
                    <option value="<?= $cardCategory['CardGroupID']; ?>">
                        <?= $cardCategory['CardGroupName']; ?>
                    </option>
                    <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Mô tả</label>
              <textarea type="text" name="Description" class="form-control" placeholder="Mô tả"></textarea>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group required">
              <label>Mã thẻ</label>
              <input type="text" name="CardNumber" class="form-control" placeholder="Mã thẻ">
            </div>
            <div class="form-group">
              <label>Ngày đăng ký</label>
              <input type="date" name="DateRegister" class="form-control" >
            </div>
            <div class="form-group">
              <label>Ngày phát </label>
              <input type="date" name="DateRelease" class="form-control" >
            </div>
            <div class="form-group">
              <label>Ngày hoạt động</label>
              <input type="date" name="ImportDate" class="form-control" >
            </div>
            <div class="form-group">
              <label>Ngày hết hạn</label>
              <input type="date" name="ExpireDate" class="form-control" >
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" name="IsLock" id="khoaThe">
            <label class="form-check-label" name="IsLock" for="khoaThe">Khóa thẻ</label>
          </div>
        </div>
      </div>
    </div>
    <!-- Thống tin chung -->
    <div class="card mt-4">
      <div class="card-header bg-success text-white">Thông tin xe</div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group required">
              <label>Biến số 1</label>
              <input type="text" name="Plate1" class="form-control" placeholder="Biến số 1">
            </div>
            <div class="form-group required">
              <label>Biến số 2</label>
              <input type="text" name="Plate2" class="form-control" placeholder="Biến số 2">
            </div>
            <div class="form-group required">
              <label>Biến số 3</label>
              <input type="text" name="Plate3" class="form-control" placeholder="Biến số 3">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group required">
              <label>Tên xe 1</label>
              <input type="text" name="VehicleName1" class="form-control" placeholder="Tên xe 1">
            </div>
            <div class="form-group required">
              <label>Tên xe 2</label>
              <input type="text" name="VehicleName2" class="form-control" placeholder="Tên xe 2">
            </div>
            <div class="form-group required">
              <label>Tên xe 3</label>
              <input type="text" name="VehicleName3" class="form-control" placeholder="Tên xe 3">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Thống tin khách hàng -->
    <div class="card mt-4">
      <div class="card-header bg-success text-white">Thông tin khách hàng</div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Tìm kiếm</label>
              <input type="text" class="form-control" placeholder="Tìm kiếm">
            </div>
            <div class="form-group required">
              <label>Nhóm KH</label>
              <select name="CustomerGroupID" class="form-control">
                <option>-Nhóm khách hàng-</option>
                <?php foreach($customerGroups as $customerGroup): ?>
                  <option value="<?= $customerGroup['CustomerGroupID'] ?>"><?= $customerGroup['CustomerGroupName'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group required">
              <label>Mã KH</label>
              <input type="text" class="form-control" name="CustomerCode" placeholder="Mã KH">
            </div>
            <div class="form-group">
              <label>SĐT</label>
              <input type="text" name="Mobile" class="form-control" placeholder="SĐT">
            </div>
            <div class="form-group">
              <label>Địa chỉ</label>
              <input type="text" class="form-control" name="Address" placeholder="Địa chỉ">
            </div>
            
          </div>
          <div class="col-md-6">
            <div class="form-group required">
              <label>Nhóm căn hộ</label>
              <select name="CompartmentID" class="form-control">
                <option>-Chọn nhóm căn hộ-</option>
                    <?php foreach($apartmentCategories as $apartmentCategory): ?>
                  <option value="<?= $apartmentCategory['CompartmentID'] ?>"><?= $apartmentCategory['CompartmentName'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Tên KH</label>
              <input type="text" name="CustomerName" class="form-control" placeholder="Tên KH">
            </div>
            <div class="form-group">
              <label>CMT</label>
              <input type="text" name="IDNumber" class="form-control" placeholder="CMT">
            </div>
            
          </div>
        </div>
      </div>
    </div>

    <div class="mt-4 btn-group-custom">
            <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> Lưu</button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Lưu và thoát</button>
            <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Nhập lại</button>
            <a href="index.php?page=card-customer-manager" class="btn btn-warning text-white"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>
    
</form>
    
  </div>