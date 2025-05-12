<?php

include_once __DIR__ . '/../api/request.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $response = apiRequest("POST", "http://localhost:8000/api/login", [
        "Username" => $username,
        "Password" => $password
    ]);
    file_put_contents('log.txt', $response); // xem lỗi trong file log.txt
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

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <form method="POST">
        <h2>Kztek</h2>
        <h3>Công ty đầu tư và phát triển</h3>
        <h3>Đăng nhập</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <div class="mb-3">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mật khẩu:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng nhập</button>
    </form>
</div>
</body>
</html>