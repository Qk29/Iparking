<?php
session_start();  // Chỉ gọi một lần ở đây
$routes = [
    'dashboard' => 'pages/dashboard.php',
    'profile' => 'pages/user/profile.php',
    'event-card' => 'pages/dashboard/show-in-out.php',
    'car-in' =>'pages/dashboard/report/car-in.php',
    'user-system' => 'pages/dashboard/system/user.php',

    // thêm route khác
];
$page = $_GET['page'] ?? 'dashboard';

// Kiểm tra token trong session
if (isset($_SESSION['token'])) {
    $view = $routes[$page] ?? 'pages/dashboard.php'; // Nếu có token, hiển thị trang dashboard
    include_once 'templates/main.php';  // Gọi layout chính
} else {
    $view = 'pages/login.php';  // Nếu không có token, điều hướng đến login
    include_once 'templates/auth.php'; // Layout trống, không sidebar
}


?>