<?php
session_start();

function check_role($required_role) {
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== $required_role) {
        header("Location: ../login/logout.php");
        exit;
    }
}
// function to check the role on each page.
?>

