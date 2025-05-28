<?php 
    include_once __DIR__ . '/../../../../api/request.php';


    // call api card-category
    $cardCategoryApiUrl = 'http://localhost:8000/api/category/card-category';
    $cardCategoryResponse = apiRequest('GET', $cardCategoryApiUrl);
    $cardCategories = json_decode($cardCategoryResponse, true);


    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_card_id'])) {
            $deleteCardId = $_POST['delete_card_id'];
            $deleteUrl = "http://localhost:8000/api/category/card-category-softdelete/$deleteCardId";
            $deleteResponse = apiRequest('PUT', $deleteUrl, ['CardGroupID' => $deleteCardId]);
            $result = json_decode($deleteResponse, true);
            if (isset($result['success']) && $result['success']) {
                echo "<script>alert('Đã xóa nhóm thẻ thành công!');</script>";
                // Refresh the page to see the changes
                echo "<script>window.location.href = 'index.php?page=card-category';</script>";
            } else {
                echo "<script>alert('Xóa thất bại: " . ($result['message'] ?? 'Lỗi không xác định') . "');</script>";
            }
        }
    }
     

?>


<div class="container mt-5">
  <h4 class="mb-4">Danh sách nhóm thẻ</h4>

   <div class="row mb-3">
    <div class="col-md-4">
      <input id="searchInput" type="text" class="form-control" placeholder="Từ khóa...">
    </div>
    <div class="col-md-2">
      <button id="searchButton" class="btn btn-sm btn-primary"><i class="bi bi-search"></i> Tìm kiếm</button>
      <button id="reloadButton" class="btn btn-sm btn-secondary">Nạp lại</button>
    </div>
    <div class="mt-3">
       <!-- Thêm mới -->
 
    <a href="index.php?page=add-card-category" class="btn btn-sm btn-success"> Thêm mới</a>
 
    </div>
    </div>


<div class="table-responsive">
    <table class="table table-bordered table-hover text-center">
      <thead class="table-light">
        
        <tr>
          <th>Tên</th>
          <th>Mô tả</th>
          <th>Trạng thái</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cardCategories as $cardCategory): ?>
        <tr class="card-category-row">
            <td class="card-group-name"><?= $cardCategory['CardGroupName'] ?></td>
            <td><?= $cardCategory['Description'] ?></td>
            <td>
                <div class="d-flex justify-content-center align-items-center">
                    <span class="badge bg-<?= $cardCategory['Inactive'] == 0 ? 'success' : 'warning' ?>">
                    <?= $cardCategory['Inactive'] == 0 ? 'Kích hoạt' : 'Ngừng kích hoạt' ?>
                    </span>
                </div>
                
            </td>
            <td class="action-icons">
                <!-- Sửa -->
                <a href="index.php?page=update-card-group&id=<?=$cardCategory['CardGroupID'] ?>" title="Sửa">
                    <i class="ace-icon fa fa-pencil bigger-120" style="color:green;"></i>
                </a>

                <!-- Xóa -->
                <form action="" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?');">
                <input type="hidden" name="delete_card_id" value="<?= $cardCategory['CardGroupID'] ?>">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function(){
    $('#searchButton').on('click', function(){
      var searchTerm = $('#searchInput').val().toLowerCase();
      $('.card-category-row').each(function(){
        var cardGroupName = $(this).find('.card-group-name').text().toLowerCase();
        if (cardGroupName.includes(searchTerm)) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });

    // Nút nạp lại
    $('#reloadButton').on('click', function () {
      location.reload();
    });
  });
</script>