<?php 
    include_once __DIR__ . '/../../../api/request.php';


    // call api card-category
    $cardCategoryApiUrl = 'http://localhost:8000/api/category/card-category';
    $cardCategoryResponse = apiRequest('GET', $cardCategoryApiUrl);
    $cardCategories = json_decode($cardCategoryResponse, true);
     

?>


<div class="container mt-5">
  <h4 class="mb-4">Danh sách nhóm thẻ</h4>

   <div class="row mb-3">
    <div class="col-md-4">
      <input type="text" class="form-control" placeholder="Từ khóa...">
    </div>
    <div class="col-md-2">
      <button class="btn btn-sm btn-primary"><i class="bi bi-search"></i> Tìm kiếm</button>
      <button class="btn btn-sm btn-secondary">Nạp lại</button>
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
        <tr >
            <td><?= $cardCategory['CardGroupName'] ?></td>
            <td><?= $cardCategory['Description'] ?></td>
            <td>
                <div class="d-flex justify-content-center align-items-center">
                    <span class="badge bg-<?= $cardCategory['Inactive'] == 0 ? 'success' : 'secondary' ?>">
                    <?= $cardCategory['Inactive'] == 0 ? 'Kích hoạt' : 'Ngừng kích hoạt' ?>
                    </span>
                </div>
                
            </td>
            <td class="action-icons">
                <!-- Sửa -->
                <a href="#" title="Sửa">
                    <i class="ace-icon fa fa-pencil bigger-120" style="color:green;"></i>
                </a>

                <!-- Xóa -->
                <a href="#" class="btnDelete" title="Xóa">
                    <i class="ace-icon fa fa-trash bigger-120" style="color:red;"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>