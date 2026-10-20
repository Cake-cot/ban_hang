<?php
// Config app parameters
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ban_giay_2hand');

// Đường dẫn gốc của website
define('APPROOT', dirname(dirname(__FILE__)));
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$script = isset($_SERVER['SCRIPT_NAME']) ? str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']) : '/ban_hang';
define('URLROOT', 'http://' . $host . $script);
define('SITENAME', '2Hand Kicks - Giày Si Hiệu Chuẩn Auth');
