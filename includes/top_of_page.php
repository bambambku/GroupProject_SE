<?php
session_start();
include('check_role.php');

$current_page = $_SERVER['PHP_SELF'];

if (strpos($current_page, 'employee') !== false) {
    check_role(1);
} elseif (strpos($current_page, 'stockManager') !== false) {
    check_role(2);
} elseif (strpos($current_page, 'manager') !== false) {
    check_role(3);
} elseif (strpos($current_page, 'director') !== false) {
    check_role(4);
} elseif (strpos($current_page, 'admin') !== false) {
    check_role(5);
}

?>
