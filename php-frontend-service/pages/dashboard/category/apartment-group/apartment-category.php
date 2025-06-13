<?php 
    include_once __DIR__ . '/../../../../api/request.php';

    // call API to get apartment categories

    $apartmentCategoryApiUrl = 'http://localhost:8000/api/category/apartment-category';
    $apartmentCategoryResponse = apiRequest('GET', $apartmentCategoryApiUrl);
    $apartmentCategories = json_decode($apartmentCategoryResponse, true);

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_apartment_id'])) {
            $deleteApartmentId = $_POST['delete_apartment_id'];
            $deleteUrl = "http://localhost:8000/api/category/apartment-category-delete/$deleteApartmentId";
            $deleteResponse = apiRequest('PUT', $deleteUrl, ['CompartmentID' => $deleteApartmentId]);
            $result = json_decode($deleteResponse, true);
            if (isset($result['status']) && $result['status'] === 'success') {
                echo "<script>alert('Đã xóa nhóm căn hộ thành công!');</script>";
                // Refresh the page to see the changes
                echo "<script>window.location.href = 'index.php?page=apartment-group';</script>";
            } else {
                echo "<script>alert('Xóa thất bại: " . ($result['message'] ?? 'Lỗi không xác định') . "');</script>";
            }
        }
    }


?>

<div class="container mt-5">
  <h4 class="mb-4">Danh sách nhóm căn hộ</h4>

   <div class="row mb-3">
    <div class="col-md-4">
      <input id="searchInput" type="text" class="form-control" placeholder="Từ khóa...">
    </div>
    <div class="col-md-2">
      <button id="searchButton" class="btn btn-sm btn-primary me-2"><i class="bi bi-search"></i> Tìm kiếm</button>
      <button id="reloadButton" class="btn btn-sm btn-secondary me-2">Nạp lại</button>
      <a href="index.php?page=add-apartment-category" class="btn btn-sm btn-success me-2"> Thêm mới</a>
    </div>
    
    </div>


<div class="table-responsive row mb-3">
    <table class="table table-bordered table-hover text-center">
      <thead class="table-light">
       
          
        <tr>
          <th style="width: 80%">Tên</th>
          <th style="width: 20%">Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($apartmentCategories as $apartment): ?>
          <tr class="apartment-category-row">
            <td class="apartment-category-name"><?= $apartment['CompartmentName'] ?></td>
            <td class="action-icons">
                <!-- Sửa -->
                <a href="index.php?page=update-apartment-category&id=<?=$apartment['CompartmentID'] ?>" title="Sửa" class="d-inline-block me-2">
                    <i class="ace-icon fa fa-pencil bigger-120" style="color:green;"></i>
                </a>

                <!-- Xóa -->
                <form action="" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?');" class="d-inline-block me-2">
                <input type="hidden" name="delete_apartment_id" value="<?= $apartment['CompartmentID'] ?>">
                <button type="submit" class="btnDelete" title="Xóa" style="border:none; background:none; cursor:pointer;">
                    <i class="ace-icon fa fa-trash bigger-120" style="color:red;"></i>
                </button>
                </form>

                
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>

<script>
  document.addEventListener('DOMContentLoaded',function(){
      var searchInput = document.getElementById('searchInput');
      var searchButton = document.getElementById('searchButton');
      var reloadButton = document.getElementById('reloadButton');
      var apartmentCategoryRows = document.querySelectorAll('.apartment-category-row'); 

      searchButton.addEventListener('click', function() {
          var keyword = searchInput.value.trim().toLowerCase();

          let hasRow = false;
          apartmentCategoryRows.forEach(function(row) {
              var nameCell = row.querySelector('.apartment-category-name');
              if (nameCell && nameCell.textContent.toLowerCase().includes(keyword)) {
                  row.style.display = '';
                  hasRow = true;
              } else {
                  row.style.display = 'none';
                  
              }
          });
          if(!hasRow) {
              alert('Không tìm thấy kết quả nào với từ khóa: ' + keyword);
          }
      });
      reloadButton.addEventListener('click', function() {
          location.reload();
      });

  })

</script>