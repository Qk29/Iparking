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
?>

<div class="container mt-5">
  <h4 class="mb-4">Danh sách người dùng</h4>

  <!-- Tìm kiếm và phân quyền -->
  <div class="row mb-3">
    <div class="col-md-4">
      <input type="text" class="form-control" placeholder="Từ khóa...">
    </div>
    <div class="col-md-2">
      <button class="btn btn-sm btn-primary"><i class="bi bi-search"></i> Tìm kiếm</button>
      <button class="btn btn-sm btn-secondary">Nạp lại</button>
    </div>
    
    <div class="col-md-2">
      <select class="form-select">
        <option selected>-- Lựa chọn --</option>
        <?php foreach($roles as $role): ?>
        <option value="<?= $role['Id'] ?>"><?= $role['RoleName']?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2 d-flex align-items-center">
      <button class="btn btn-sm btn-warning">Phân quyền</button>
    </div>
  </div>

  <!-- Bảng người dùng -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover text-center">
      <thead class="table-light">
        <tr>
          <th><input type="checkbox"></th>
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
        <td><input type="checkbox"></td>
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
            <a href="#" title="Sửa">
                <i class="ace-icon fa fa-pencil bigger-120" style="color:green;"></i>
            </a>

            <!-- Xóa -->
            <a href="#" class="btnDelete" title="Xóa">
                <i class="ace-icon fa fa-trash bigger-120" style="color:red;"></i>
            </a>

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

  <!-- Thêm mới -->
  <div class="mt-3">
    <button class="btn btn-sm btn-success"><i class="bi bi-plus-circle"></i> Thêm mới</button>
  </div>
</div>


