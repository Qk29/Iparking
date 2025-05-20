
<!-- 
if (!isset($_SESSION['user'])) {
    header('Location: ../pages/login.php');
    exit;
} -->

<?php

include_once __DIR__ .  '/../../api/request.php';


$user = $_SESSION['user'];
$id = $user['Id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nếu form cập nhật thông tin
    if (isset($_POST['update_info'])) {
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'username' => $_POST['username'],
            'phone' => $_POST['phone']
        ];

        $response = apiRequest('PUT', "http://localhost:8000/api/users/$id", $data);
        $result = json_decode($response, true);
    
        if ( isset($result['success']) && $result['success']) {
            echo "<script>alert('Cập nhật thông tin thành công');</script>";
        } elseif(isset($result['message']) && !$result['message']) {
            echo "<script>alert('Thất bại: " . $result['message'] . "');</script>";
        }

    // Nếu form đổi mật khẩu
    } elseif (isset($_POST['update_password'])) {
        $data = [
            'current_password' => $_POST['current_password'],
            'new_password' => $_POST['new_password'],
            'confirm_password' => $_POST['confirm_password'],
            
        ];

        $response = apiRequest('PUT', "http://localhost:8000/api/users/$id/change-password", $data);
        $result = json_decode($response, true);

        if (isset($result['success']) &&$result['success']) {
            echo "<script>alert('Đổi mật khẩu thành công');</script>";
        } elseif(isset($result['message']) && !$result['message']) {
            echo "<script>alert('Lỗi: " . $result['message'] . "');</script>";
        }
    }
}
// echo '<pre>';
// print_r($_SESSION['user']);
// echo '</pre>';



?>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab"  href="#profile">Thông tin</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#password">Mật khẩu</a>
    </li>
</ul>

<div class="tab-content">
    <!-- Tab Thông tin -->
    <div id="profile" class="tab-pane fade show active">
        <form method="POST">
        <div class="mb-3">
            <label>Họ tên</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['Name']) ?>">
        </div>
        <div class="mb-3">
            <label>Tên đăng nhập</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['Username']) ?>">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required >
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required >
        </div>
        <a href="index.php" class="btn btn-secondary">Quay lại</a>
        <button type="submit" name="update_info" class="btn btn-success">Cập nhật</button>
        <a href="index.php" class="btn btn-warning">Nhập lại</a>
    </form>
    </div>

    <!-- Tab Mật khẩu -->
    <div id="password" class="tab-pane fade">
        <form action="" method="POST">
            <div class="form-group">
                <label>Mật khẩu hiện tại</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Mật khẩu mới</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Nhập lại mật khẩu mới</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>

            <a href="index.php" class="btn btn-secondary">Quay lại</a>
            <button type="submit" name="update_password" class="btn btn-success">Cập nhật</button>
            <a href="index.php" class="btn btn-warning">Nhập lại</a>
            
            
            
            
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



