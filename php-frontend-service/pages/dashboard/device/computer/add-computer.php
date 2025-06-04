

<?php 
    include_once __DIR__ . '/../../../../api/request.php';  


    // call api to get gate list
    $gateApiUrl = 'http://localhost:8000/api/equipment/gate-list';
    $gateResponse = apiRequest('GET', $gateApiUrl);
    $gates = json_decode($gateResponse, true);
    // call api to add new computer
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $computerData = [
            'ComputerName' => $_POST['ComputerName'] ?? '',
            'IPAddress' => $_POST['IPAddress'] ?? '',
            'GateID' => $_POST['gate'] ?? '',
            'Description' => $_POST['Description'] ?? '',
            'PicPathIn' => $_POST['PicPathIn'] ?? null,
            'PicPathOut' => $_POST['PicPathOut'] ?? null,
            'VideoPath' => $_POST['VideoPath'] ?? null,
            'SortOrder' => $_POST['SortOrder'] ?? '',
            'Inactive' => isset($_POST['Inactive']) ? 0 : 1,
            'VideoDays' => $_POST['VideoDays'] ?? 0
        ];

        $computerApiUrl = 'http://localhost:8000/api/equipment/add-computer';
        $response = apiRequest('POST', $computerApiUrl, $computerData);
        $responseData = json_decode($response, true);
        

         if (isset($responseData['status']) && $responseData['status'] === 'success') {  
            echo '<div class="alert alert-success">Cập nhật máy tính thành công!</div>';
            // Redirect or perform other actions as needed
        } else {
            echo '<div class="alert alert-danger">Lỗi khi cập nhật mới máy tính: ' . htmlspecialchars($responseData['message'] ?? 'Không rõ lỗi') . '</div>';
        }
    }
    
    

   
?>

<div class="container mt-5">
  <h2 class="mb-4">Thêm mới máy tính</h2>
  <form method="POST">
    
      <!-- Thông tin cơ bản -->
      <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Tên máy tính <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="ComputerName" placeholder="Tên máy tính" >
        </div>
      </div>
   

    <!-- Thông tin cơ bản -->
      <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Địa chỉ IP <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="IPAddress" placeholder="địa chỉ IP" >
        </div>
      </div>

         <div class="col-md-5 mt-2 form-section">
            <label class="form-label">Tên cổng<span class="text-danger">*</span></label>   
            <select class="form-select" name="gate" id="">
            <option value="#">-- Chọn cổng --</option>
            <?php foreach ($gates as $gate): ?>
                <option value="<?= $gate['GateID'] ?>"><?= $gate['GateName'] ?></option>
            <?php endforeach; ?>
        </select>
         </div>



    <div class="col-md-5 mt-2 mt-3 form-section">
        <div class="form-group"><label class="form-label">Mô tả <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="Description" placeholder="Mô tả " >
        </div>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Đường dẫn ảnh vào<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="PicPathIn" placeholder="Đường dẫn ảnh vào" >
        </div>
      </div>

      
    <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Đường dẫn ảnh ra<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="PicPathOut" placeholder="Đường dẫn ảnh ra" >
        </div>
      </div>

      
    <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Đường dẫn video<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="VideoPath" placeholder="Đường dẫn video" >
        </div>
      </div>
      
    <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">STT<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="SortOrder" placeholder="Tên máy tính" >
        </div>
      </div>

    <input type="hidden" name="VideoDays">

    

    <div class="form-check mt-3">
        <input type="checkbox" class="form-check-input" name="Inactive" id="inactiveCheck">
        <label class="form-check-label" for="inactiveCheck">Ngừng sử dụng</label>
    </div>

    </div>

    
    <div class="mt-4 btn-group-custom">
      <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> Lưu</button>
      <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Lưu và thoát</button>
      <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Nhập lại</button>
      <a href="index.php?page=computer" class="btn btn-warning text-white"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>
    </form>
</div>
    