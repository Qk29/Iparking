<?php
session_start();
session_unset(); // Xóa tất cả session
session_destroy(); // Hủy session

// Chuyển hướng về trang đăng nhập
header("Location: login.php");
exit;
