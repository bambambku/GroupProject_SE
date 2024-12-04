<?php
session_start();

// Redirect if not logged in or if not a director (user role 'Director')
if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] != 4) {
  header("Location: ../logout.php");    exit();
}

// Additional logic can be placed here if needed
