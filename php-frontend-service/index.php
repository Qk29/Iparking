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

    // Thiết bị/ máy tính
    'computer' => 'pages/dashboard/device/computer/computer-list.php',
    'add-computer'=> 'pages/dashboard/device/computer/add-computer.php',
    'update-computer' => 'pages/dashboard/device/computer/update-computer.php',
    

    // Thiết bị/ camera
    'camera' => 'pages/dashboard/device/camera/camera-list.php',
    'add-camera' => 'pages/dashboard/device/camera/add-camera.php',
    'update-camera' => 'pages/dashboard/device/camera/update-camera.php',

    // thiết bị / bộ điều khiển
    'controller' => 'pages/dashboard/device/controller/controller-list.php',
    'add-controller' => 'pages/dashboard/device/controller/add-controller.php',
    'update-controller' =>'pages/dashboard/device/controller/update-controller.php',


    //thiết bị / led hiển thị
    'led-display' => 'pages/dashboard/device/led/led-list.php',
    'add-led' => 'pages/dashboard/device/led/add-led.php',
    'update-led' => 'pages/dashboard/device/led/update-led.php',
    'export-led' => 'pages/dashboard/device/led/export-led.php',

    // thiết bị/ làn vào ra
    'in-out-lane' => 'pages/dashboard/device/lane/lane-list.php',
    'add-lane' => 'pages/dashboard/device/lane/add-lane.php',
    'update-lane' => 'pages/dashboard/device/lane/update-lane.php',


    // quản lý khách hàng/danh sách khách hàng
    'customer' => 'pages/dashboard/customer-manager/customer-list.php',
    'add-customer-manager' => 'pages/dashboard/customer-manager/add-customer-manager.php',
    'update-customer-manager' => 'pages/dashboard/customer-manager/update-customer-manager.php',


    // Quản lý thẻ 
    'card-customer-manager' => 'pages/dashboard/card-manager/card-list.php',
    'add-card-manager' => 'pages/dashboard/card-manager/add-card-manager.php',

    
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