<?php 
     include_once __DIR__ . '/../../../api/request.php';
    // call api user
    $apiUrl = 'http://localhost:8000/api/system/users';
    $response = apiRequest('GET',$apiUrl);
    $users = json_decode($response, true);

    // call api role
    $roleApiUrl = 'http://localhost:8000/api/system/roles';
    $roleResponse = apiRequest('GET', $roleApiUrl);
    $roles = json_decode($roleResponse, true);

    


    if($_SERVER['REQUEST_METHOD'] === 'POST') {

      if(isset($_POST['role_id'])) {
        $roleId = $_POST['role_id'] ?? null;
        $userIds = $_POST['user_ids'] ?? [];
        
        if (!empty($userIds)) {
            foreach ($userIds as $userId) {
                $updateUrl = "http://localhost:8000/api/system/users/$userId/role";
                apiRequest('PUT', $updateUrl, ['role_id' => $roleId]);
            }
            echo "<script>alert('Phân quyền thành công!');</script>";
            // Refresh the page to see the changes
            echo "<script>window.location.href = 'index.php?page=user-system';</script>";
            exit;
        } else {
            echo "<script>alert('Vui lòng chọn ít nhất một người dùng!');</script>";
        }
    }

      if(isset($_POST['delete_id'])) {
              $deleteId = $_POST['delete_id'];
              $deleteUrl = "http://localhost:8000/api/system/users/$deleteId/soft-delete";
              $deleteResponse = apiRequest('PUT', $deleteUrl);

              $result = json_decode($deleteResponse, true);
              if(isset($result['success']) && $result['success']) {
                  echo "<script>alert('Đã xoá mềm người dùng thành công!'); </script>";
                  // Refresh the page to see the changes
                  echo "<script>window.location.href = 'index.php?page=user-system';</script>";
              } else {
                  echo "<script>alert('Xoá mềm thất bại: " . ($result['message'] ?? 'Lỗi không xác định') . "');</script>";
              }
      }
      
}

    
?>

<div class="container mt-5">
  <h4 class="mb-4">Danh sách người dùng</h4>

  <!-- Tìm kiếm và phân quyền -->
   <form method="POST" action="">
  <div class="row mb-3">
    <div class="col-md-4">
      <input type="text" class="form-control" placeholder="Từ khóa...">
    </div>
    <div class="col-md-2">
      <button class="btn btn-sm btn-primary"><i class="bi bi-search"></i> Tìm kiếm</button>
      <button class="btn btn-sm btn-secondary">Nạp lại</button>
    </div>
    
    
    <div class="col-md-2">
      <select class="form-select" name="role_id">
        <option selected>-- Lựa chọn --</option>
        <?php foreach($roles as $role): ?>
        <option value="<?= $role['Id'] ?>"><?= $role['RoleName']?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2 d-flex align-items-center">
      <button type="submit" class="btn btn-sm btn-warning">Phân quyền</button>
    </div>

    <div class="col-md-2 d-flex align-items-center">
       <!-- Thêm mới -->
 
    <a href="index.php?page=add-user" class="btn btn-sm btn-success"> Thêm mới</a>
 
    </div>
    
  </div>



  <!-- Bảng người dùng -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover text-center">
      <thead class="table-light">
        <tr>
          <th><input type="checkbox" id="checkAll"></th>
          <th>Tên người dùng</th>
          <th>Số điện thoại</th>
          <th>Tên đăng nhập</th>
          <th>Ngày tạo</th>
          <th>Trạng thái</th>
          <th>Vai trò</th>
          <th>Quyền hạn</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
         <?php if (!empty($users)) : ?>
    <?php foreach ($users as $user) : ?>
      <tr>
        <td><input type="checkbox" class="user-checkbox" name="user_ids[]" value="<?= $user['Id'] ?>"></td>
        <td><?= $user['Name'] ?></td>
        <td><?= $user['Phone'] ?></td>
        <td><?= $user['Username'] ?></td>
        <td><?= $user['DateCreated'] ?></td>
        <td>
          <?php if ($user['Active'] === '1'): ?>
            <span class="badge bg-success">Kích hoạt</span>
          <?php else: ?>
            <span class="badge bg-secondary">Không hoạt động</span>
          <?php endif; ?>
        </td>
        <td><span class="badge bg-<?= $user['Admin'] === '1' ? 'danger' : 'primary' ?>"><?= $user['Admin'] === '1' ? 'Admin' : 'User' ?></span></td>
        <td><?= $user['RoleName']?></td>
        <td class="action-icons">
            <!-- Sửa -->
            <a href="index.php?page=update-user-system" title="Sửa">
                <i class="ace-icon fa fa-pencil bigger-120" style="color:green;"></i>
            </a>

            <!-- Xóa -->
            <form action="" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?');">
            <input type="hidden" name="delete_id" value="<?= $user['Id'] ?>">
            <button type="submit" class="btnDelete" title="Xóa" style="border:none; background:none; cursor:pointer;">
                <i class="ace-icon fa fa-trash bigger-120" style="color:red;"></i>
            </button>
            </form>
            <!-- Phục hồi -->
            <a href="#" class="btnRes" title="Phục hồi">
                <i class="ace-icon fa fa-recycle bigger-120" style="color:orange;"></i>
            </a>
        </td>

      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="9">Không có người dùng nào.</td>
    </tr>
  <?php endif; ?>
      </tbody>
    </table>
  </div>
    </form>

  <!-- Phân trang -->
  <nav>
    <ul class="pagination">
      <li class="page-item disabled"><a class="page-link">First</a></li>
      <li class="page-item disabled"><a class="page-link">Previous</a></li>
      <li class="page-item active"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">Next</a></li>
      <li class="page-item"><a class="page-link" href="#">Last</a></li>
    </ul>
  </nav>

 
</div>

<script>
  document.getElementById('checkAll').addEventListener('change', function () {
    const isChecked = this.checked;
    document.querySelectorAll('.user-checkbox').forEach(function (checkbox) {
      checkbox.checked = isChecked;
    });
  });

  
</script>


