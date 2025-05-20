<?php 
    include_once __DIR__ . '/../../../api/request.php';

    // call api role
    $roleApiUrl = 'http://localhost:8000/api/system/roles';
    $roleResponse = apiRequest('GET', $roleApiUrl);
    $roles = json_decode($roleResponse, true);

?>


<div class="container mt-5">
  <h4 class="mb-4">Danh sách vai trò</h4>

   <div class="row mb-3">
    <div class="col-md-4">
      <input type="text" class="form-control" placeholder="Từ khóa...">
    </div>
    <div class="col-md-2">
      <button class="btn btn-sm btn-primary"><i class="bi bi-search"></i> Tìm kiếm</button>
      <button class="btn btn-sm btn-secondary">Nạp lại</button>
    </div>
    </div>


<div class="table-responsive">
    <table class="table table-bordered table-hover text-center">
      <thead class="table-light">
        <tr>
          <th>Id</th>
          <th>Tên vai trò</th>
          <th>Mô tả</th>
          <th>Trạng thái</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
     
        <?php foreach($roles as $role): ?>
        <tr >
          <td><?= $role['Id'] ?></td>
          <td><?= $role['RoleName'] ?></td>
          <td><?= $role['Description'] ?></td>
          <td>
                <div class="d-flex justify-content-center align-items-center">
                    <span class="badge bg-<?= $role['Active'] == 1 ? 'success' : 'secondary' ?>">
                    <?= $role['Active'] == 1 ? 'Kích hoạt' : 'Ngừng kích hoạt' ?>
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