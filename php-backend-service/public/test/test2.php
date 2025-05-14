<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Gây lỗi thử
echo $undefined_variable;
echo $hihi;

error_log("This is a test error log message.");

?>