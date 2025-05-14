<?php
error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('display_errors', '0');
ini_set('error_log', __DIR__ . '/frontend_test_error.log');

echo $undefined_variable; // Undefined variable
trigger_error("Lỗi test frontend", E_USER_WARNING);