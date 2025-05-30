

<?php 
    include_once __DIR__ . '/../../../../api/request.php';  

    // call api to add new gate
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'GateName' => $_POST['CustomerGroupName'] ?? '',
            'Description' => $_POST['Description'] ?? '',
            'SortOrder' => $_POST['SortOrder'] ?? 0,
            'Inactive' => isset($_POST['Inactive']) ? 1 : 0
        ];

        $addGateApiUrl = 'http://localhost:8000/api/equipment/add-gate';
        $response = apiRequest('POST', $addGateApiUrl, $data);
        
        $responseData = json_decode($response, true);
        if (isset($responseData['status']) && $responseData['status'] === 'success') {  
            echo '<div class="alert alert-success">Thêm mới cổng thành công!</div>';
            // Redirect or perform other actions as needed
        } else {
            echo '<div class="alert alert-danger">Lỗi khi thêm mới cổng: ' . htmlspecialchars($responseData['message'] ?? 'Không rõ lỗi') . '</div>';
        }
    } 
    

   
?>

<div class="container mt-5">
  <h2 class="mb-4">Thêm mới cổng</h2>
  <form method="POST">
    
      <!-- Thông tin cơ bản -->
      <div class="col-md-5 form-section">
        <div class="form-group"><label class="form-label">Tên cổng <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="GateName" placeholder="Tên cổng" >
        </div>
      </div>
   

    <!-- Thông tin cơ bản -->
      <div class="col-md-5 form-section">
        <div class="form-group"><label class="form-label">Mô tả <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="Description" placeholder="Mô tả" >
        </div>
      </div>

    <div class="col-md-5 mt-3 form-section">
        <div class="form-group"><label class="form-label">Số thứ tự <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="SortOrder" placeholder="Số thứ tự " >
        </div>
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
      <a href="index.php?page=gate" class="btn btn-warning text-white"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>
    </form>
</div>
    