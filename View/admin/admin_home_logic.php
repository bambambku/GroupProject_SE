<?php 
if (session_status() === PHP_SESSION_NONE){
    session_start();
}

if ($_SESSION['user_role'] != 5){
    header('Location: ../login/login.php');
}
?>