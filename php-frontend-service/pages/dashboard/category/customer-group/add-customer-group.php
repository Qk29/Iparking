

<?php 
    include_once __DIR__ . '/../../../../api/request.php';  

    // call api to get customer groups
    $customerGroupApiUrl = 'http://localhost:8000/api/category/customer-group';
    $customerGroupResponse = apiRequest('GET', $customerGroupApiUrl);
    $customerGroups = json_decode($customerGroupResponse, true);

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'CustomerGroupName' => $_POST['CustomerGroupName'] ?? '',
            'ParentId' => $_POST['ParentId'] ?? 0,
            'Ordering' => $_POST['Ordering'] ?? 0,
            'SortOrder' => $_POST['SortOrder'] ?? 0,
            'QuotaCar' => $_POST['QuotaCar'] ?? 0,
            'QuotaBike' => $_POST['QuotaBike'] ?? 0,
            'QuotaMotor' => $_POST['QuotaMotor'] ?? 0,
            'IsCompany' => $_POST['IsCompany'] ?? 0,
            'Inactive' => isset($_POST['Inactive']) ? 1 : 0
        ];

        $addCustomerGroupApiUrl = 'http://localhost:8000/api/category/add-customer-group';
        $response = apiRequest('POST', $addCustomerGroupApiUrl, $data);
        if (empty($response)) {
            echo "API trả về response rỗng";
        } else {
            echo "Response từ API: " . htmlspecialchars($response);
        }

        $responseData = json_decode($response, true);
        if (isset($responseData['status']) && $responseData['status'] === 'success') {  
            echo '<div class="alert alert-success">Thêm mới nhóm khách hàng thành công!</div>';
            // Redirect or perform other actions as needed
        } else {
            echo '<div class="alert alert-danger">Lỗi khi thêm mới nhóm khách hàng: ' . htmlspecialchars($responseData['message'] ?? 'Không rõ lỗi') . '</div>';
        }
    }

   
?>

<div class="container mt-5">
  <h2 class="mb-4">Thêm mới nhóm khách hàng</h2>
  <form method="POST">
    <div class="row">
      <!-- Thông tin cơ bản -->
      <div class="col-md-5 form-section">
        <div class="form-group"><label class="form-label">Tên nhóm khách hàng <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="CustomerGroupName" placeholder="Tên nhóm khách hàng" required>
        </div>
      </div>
    </div>

    <div class="col-md-5 mt-3 form-section">
        <div class="form-group"><label class="form-label">Cấp cha <span class="text-danger">*</span></label>
            <select class="form-select" name="ParentId" required>
            <option value="">Chọn cấp cha</option>
            <?php foreach ($customerGroups as $group): ?>
                <option value="<?= $group['CustomerGroupID'] ?>"><?= $group['CustomerGroupName'] ?></option>
            <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-md-5 mt-3 form-section">
        <div class="form-group"><label class="form-label">Số thứ tự <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="Ordering" placeholder="Số thứ tự " required>
        </div>
    </div>

    <div class="col-md-5 mt-3 form-section">
        <input type="hidden" hidden class="form-control" name="SortOrder" >
    </div>
    <div class="col-md-5 mt-3 form-section">
        <input type="hidden"  class="form-control" name="QuotaCar" >
    </div>
    <div class="col-md-5 mt-3 form-section">
        <input type="hidden"  class="form-control" name="QuotaBike" >
    </div>
    <div class="col-md-5 mt-3 form-section">
        <input type="hidden"  class="form-control" name="QuotaMotor" >
    </div>
    <div class="col-md-5 mt-3 form-section">
        <input type="hidden"  class="form-control" name="IsCompany" >
    </div>

    

    <div class="form-check mt-3">
        <input type="checkbox" class="form-check-input" name="Inactive" id="inactiveCheck">
        <label class="form-check-label" for="inactiveCheck">Ngừng sử dụng</label>
    </div>

    </div>

    
    <div class="mt-4 btn-group-custom">
      <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> Lưu</button>
      <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Lưu và thoát</button>
      <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Nhập lại</button>
      <a href="index.php?page=customer-group" class="btn btn-warning text-white"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>
    </form>
</div>
    