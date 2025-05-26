<?php
session_start();  // Chỉ gọi một lần ở đây
$routes = [
    // Trang chính
    'dashboard' => 'pages/dashboard.php',
    'profile' => 'pages/user/profile.php',

    // Bàn làm việc
    'event-card' => 'pages/dashboard/show-in-out.php',

    // Báo cáo
    'car-in' =>'pages/dashboard/report/car-in.php',


    // Hệ thống
    'user-system' => 'pages/dashboard/system/user.php',
    'role-system' => 'pages/dashboard/system/role-system.php',
    'add-user' => 'pages/dashboard/system/add-user.php',
    'update-user-system' => 'pages/dashboard/system/update-user-system.php',

    // Danh mục
    'card-category' => 'pages/dashboard/category/card-category.php',
    'add-card-category' => 'pages/dashboard/category/add-card.php',
    'update-card-group' => 'pages/dashboard/category/update-card-cate.php',
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