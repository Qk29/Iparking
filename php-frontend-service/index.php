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

    // Danh mục/ nhóm thẻ
    'card-category' => 'pages/dashboard/category/cardgroup/card-category.php',
    'add-card-category' => 'pages/dashboard/category/cardgroup/add-card.php',
    'update-card-group' => 'pages/dashboard/category/cardgroup/update-card-cate.php',

    // Danh mục/ nhóm căn hộ
    'apartment-group' => 'pages/dashboard/category/apartment-group/apartment-category.php',
    'add-apartment-category' => 'pages/dashboard/category/apartment-group/add-apartment-category.php',
    'update-apartment-category' => 'pages/dashboard/category/apartment-group/update-apartment-category.php',

    // Danh mục/ nhóm khách hàng
    'customer-group' => 'pages/dashboard/category/customer-group/customer-group.php',
    'add-customer-group' => 'pages/dashboard/category/customer-group/add-customer-group.php',
    'update-customer-group' => 'pages/dashboard/category/customer-group/update-customer-group.php',

    // Thiết bị/ Cổng
    'gate' => 'pages/dashboard/device/gate/gate-list.php',
    'add-gate' => 'pages/dashboard/device/gate/add-gate.php',
    'update-gate' => 'pages/dashboard/device/gate/update-gate.php',

    

    
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