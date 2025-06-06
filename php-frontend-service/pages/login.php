<?php

include_once __DIR__ . '/../api/request.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $response = apiRequest("POST", "http://localhost:8000/api/login", [
        "Username" => $username,
        "Password" => $password
    ]);
    
    $result = json_decode($response, true);

    if (isset($result['token'])) {
        session_start();
        $_SESSION['token'] = $result['token'];
        $_SESSION['user'] = $result['user'];
        header("Location: ../index.php");
        exit;
    } else {
        $error = "Sai thông tin đăng nhập.";
    }

    
}
?>


<div class="container">
    <div class="login-container">
        <div class="text-center mb-4">
            <div class="company-name">Kztek</div>
            <div class="company-slogan">Công ty đầu tư và phát triển</div>
            <h3 class="login-title">Đăng nhập</h3>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
            <button type="submit" class="btn btn-primary btn-login">Đăng nhập</button>
        </form>
    </div>
</div>

