
<?php 
    include_once __DIR__ . '/../../../../api/request.php';  


    // call API to add new apartment category
    $apiAddApartmentCategoryUrl = 'http://localhost:8000/api/category/add-apartment-category';

    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $data = [
            'CompartmentName' => $_POST['CompartmentName'] ?? '',
            'SortOrder' => $_POST['SortOrder'] ?? ''
        ];

        $response = apiRequest('POST', $apiAddApartmentCategoryUrl, $data);
        var_dump($response);
        $result = json_decode($response, true);
        if($result && $result['status'] === 'success'){
            echo "<script>alert('Tạo mới nhóm thẻ thành công!');</script>";
        }else{
            echo "<script>alert('Tạo mới nhóm thẻ thất bại!');</script>";
        }
        
    }
?>

<div class="container mt-5">
  <h2 class="mb-4">Thêm mới nhóm thẻ</h2>
  <form method="POST">
    <div class="row">
      <!-- Thông tin cơ bản -->
      <div class="col-md-5 form-section">
        <div class="form-group"><label class="form-label">Tên nhóm căn hộ <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="CompartmentName" placeholder="Tên nhóm căn hộ" required>
        </div>
      </div>
    </div>

    <div class="col-md-5 mt-3 form-section">
        <div class="form-group"><label class="form-label">Số thứ tự <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="SortOrder" placeholder="Số thứ tự" >
        </div>
      </div>
    </div>
    <div class="mt-4 btn-group-custom">
      <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> Lưu</button>
      <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Lưu và thoát</button>
      <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Nhập lại</button>
      <a href="index.php?page=apartment-group" class="btn btn-warning text-white"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>
    </form>
</div>
    