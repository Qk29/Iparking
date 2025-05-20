<?php 
    include_once __DIR__ . '/../../../api/request.php';

    $apiUrl = 'http://localhost:8000/api/system/add-user';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];
        $name = $_POST['name'];
        $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;
        $isActive = isset($_POST['isActive']) ? 1 : 0;
        $roles = isset($_POST['roles']) ? $_POST['roles'] : [];
       

        // Gửi yêu cầu tạo người dùng
        $data = [
            'username' => $username,
            'password' => $password,
            'repassword' => $repassword,
            'name' => $name,
            'isAdmin' => $isAdmin,
            'isActive' => $isActive,
            'roles' => $roles,
        ];

        var_dump($data);

        // Gửi yêu cầu POST đến API
        $response = apiRequest('POST', $apiUrl, $data);
        
        // Xử lý phản hồi từ API
        if ($response) {
            echo "$response";
            echo "<script>alert('Tạo mới người dùng thành công!');</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra khi tạo mới người dùng.');</script>";
        }
    }
?>


<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Tạo mới người dùng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    .form-section {
      border-right: 1px solid #ddd;
    }
    .form-label {
      font-weight: bold;
    }
    .btn-group-custom button {
      margin-right: 10px;
    }
    .permission-box {
      padding-left: 20px;
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <h4 class="mb-4">Tạo mới người dùng</h4>
  <form method="POST">
    <div class="row">
      <!-- Thông tin cơ bản -->
      <div class="col-md-8 form-section">
        <h5 class="mb-3">Thông tin cơ bản</h5>

        <div class="form-group">
          <label class="form-label">Tài khoản đăng nhập <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập">
        </div>

        <div class="form-group">
          <label class="form-label">Mật khẩu <span class="text-danger">*</span></label>
          <input type="password" class="form-control" name="password" placeholder="Mật khẩu">
        </div>

        <div class="form-group">
          <label class="form-label">Nhập lại mật khẩu</label>
          <input type="password" name="repassword" class="form-control" placeholder="Nhập lại mật khẩu">
        </div>

        <div class="form-group">
          <label class="form-label">Họ tên</label>
          <input type="text" name="name" class="form-control" placeholder="Họ tên">
        </div>

        <div class="form-group form-check">
          <input type="checkbox" name="isAdmin" class="form-check-input" id="isAdmin">
          <label class="form-check-label" for="isAdmin">Is Admin</label>
        </div>

        <div class="form-group form-check">
          <input type="checkbox" name="isActive" class="form-check-input" id="isActive" checked>
          <label class="form-check-label" for="isActive">Kích hoạt</label>
        </div>

       
      </div>

      <!-- Danh sách quyền hạn -->
      <div class="col-md-4">
        <h5 class="mb-3">Danh sách quyền hạn</h5>
        <div class="permission-box">
          <div class="form-check">
            <input class="form-check-input" name="roles[]" value="103917362" type="checkbox" id="quyen1">
            <label class="form-check-label" for="quyen1">Bảo vệ</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" name="roles[]" value="33911229" type="checkbox" id="quyen2">
            <label class="form-check-label" for="quyen2">Kế Toán</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" name="roles[]" value="62172058" type="checkbox" id="quyen3">
            <label class="form-check-label" for="quyen3">Hành chính</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" name="roles[]" value="87044824" type="checkbox" id="quyen4">
            <label class="form-check-label" for="quyen4">Dịch Vụ</label>
          </div>
        </div>
      </div>
    </div>

    <!-- Buttons -->
    <div class="mt-4 btn-group-custom">
      <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> Lưu</button>
      <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Lưu và thoát</button>
      <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Nhập lại</button>
      <a href="index.php?page=user-system" class="btn btn-warning text-white"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>
  </form>
</div>
</body>
</html>
