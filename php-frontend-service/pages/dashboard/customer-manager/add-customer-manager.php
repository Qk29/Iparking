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

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
        'CustomerCode'      => $_POST['CustomerCode'] ?? '',
        'CustomerName'      => $_POST['CustomerName'] ?? '',
        'IDNumber'          => $_POST['IDNumber'] ?? '',
        'Mobile'            => $_POST['Mobile'] ?? '',
        'CustomerGroupID'   => $_POST['CustomerGroupID'] ?? '',
        'CompartmentID'     => $_POST['CompartmentID'] ?? '',
        'Address'           => $_POST['Address'] ?? '',
        'EnableAccount'     => isset($_POST['EnableAccount']) ? 1 : 0,
        'Account'           => $_POST['Account'] ?? '',
        'Password'          => $_POST['Password'] ?? '',
        'RePassword'        => $_POST['RePassword'] ?? '',
        'Inactive'          => isset($_POST['Inactive']) ? 0 : 1,
        'DateInConstruction'=> $_POST['DateInConstruction'] ?? date('Y-m-d H:i:s'),
        'Birthday'          => $_POST['Birthday'] ?? date('Y-m-d H:i:s'),
        'DateUpdate' => $_POST['DateUpdate'] ?? date('Y-m-d H:i:s'),

 
        'AccessLevelID'     => $_POST['AccessLevelID'] ?? '',
        'Finger1'           => $_POST['Finger1'] ?? '',
        'Finger2'           => $_POST['Finger2'] ?? '',
        'UserIDofFinger'    => $_POST['UserIDofFinger'] ?? 0,
        'DevPass'           => $_POST['DevPass'] ?? '',
        'AccessExpireDate'  => $_POST['AccessExpireDate'] ?? '',
        'UserFaceId'        => $_POST['UserFaceId'] ?? 0,
    ];

    // Kiểm tra nếu có file upload
    if (isset($_FILES['Avatar']) && $_FILES['Avatar']['error'] == 0) {
    $fileTmpPath = $_FILES['Avatar']['tmp_name'];
    $fileData = file_get_contents($fileTmpPath);
    $data['Avatar'] = base64_encode($fileData); // <- dùng cột Avatar để lưu nội dung ảnh
    }

    // Gửi dữ liệu đến API
    $response = apiRequest('POST', 'http://localhost:8000/api/customer-manager/add-customer', $data);
    var_dump($response);
    $result = json_decode($response, true);

    // Xử lý phản hồi
    if (!empty($result['status']) && $result['status'] === 'success') {
        // Redirect hoặc thông báo
        echo "<div class='alert alert-success'>Thêm mới khách hàng thành công!</div>";
        echo "<script>window.location.href = 'index.php?page=customer';</script>";
    } else {
        echo "<div class='alert alert-danger'>Thêm thất bại!</div>";
    }
 }

?>


<div class="container">
    <div class="card">
      <div class="card-header bg-success text-white">
        Thêm mới khách hàng
      </div>
      <div class="card-body">
        <form method="POST" >
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Mã KH *</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="CustomerCode" placeholder="Mã KH">
            </div>
            <label class="col-sm-2 col-form-label">Tên KH *</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="CustomerName" placeholder="Tên KH">
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">CMND</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="IDNumber" placeholder="CMND">
            </div>
            <label class="col-sm-2 col-form-label">Điện thoại</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="Mobile" placeholder="Điện thoại">
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Nhóm KH</label>
            <div class="col-sm-4">
              <select class="form-select" name="CustomerGroupID">
                <option value="">-- Chọn nhóm khách hàng --</option>
                <?php foreach($customerGroups as $customerGroup): ?>
                  <option value="<?= $customerGroup['CustomerGroupID'] ?>"><?= $customerGroup['CustomerGroupName'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <label class="col-sm-2 col-form-label">Căn hộ</label>
            <div class="col-sm-4">
              <select class="form-select" name="CompartmentID">
                <option value="">-- Chọn căn hộ --</option>
                <?php foreach($apartmentCategories as $apartmentCategory): ?>
                  <option value="<?= $apartmentCategory['CompartmentID'] ?>"><?= $apartmentCategory['CompartmentName'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Địa chỉ</label>
            <div class="col-sm-10">
              <textarea class="form-control" name="Address" rows="3"></textarea>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-2">
              <div class="form-check">
                <input type="checkbox" name="EnableAccount" class="form-check-input">
                <label class="form-check-label" for="chophep">Cho phép đăng nhập</label>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Tên đăng nhập</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="Account" value="">
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Mật khẩu</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="Password" value="">
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Nhập lại mật khẩu</label>
            <div class="col-sm-10">
              <input type="password" name="RePassword" class="form-control">
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Ảnh đại diện</label>
            <div class="col-sm-10">
              <input type="file" name="Avatar" class="form-control">
            </div>
          </div>

          <input type="hidden" name="Inactive" value="0">
          <input type="hidden"   name="DateInConstruction" value="">
          <input type="hidden"  name="Birthday" value="">
          <input type="hidden"  name="DateUpdate" value="">
          <input type="hidden"  name="AccessLevelID" value="">
          <input type="hidden"  name="Finger1" value="">
          <input type="hidden"  name="Finger2" value="">
          <input type="hidden"  name="UserIDofFinger" value="">
          <input type="hidden"  name="DevPass" value="">
          <input type="hidden"  name="AccessExpireDate" value="">
          <input type="hidden"  name="UserFaceId" value="">

          <div class="mt-4 btn-group-custom">
            <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> Lưu</button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Lưu và thoát</button>
            <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Nhập lại</button>
            <a href="index.php?page=controller" class="btn btn-warning text-white"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
        </form>
      </div>
    </div>
    
  </div>