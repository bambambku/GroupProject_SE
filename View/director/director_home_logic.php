<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// logout and redirect to login if user is not logged in or not an employee 
if ($_SESSION["user_role"] != 4) {
  if ($_SESSION["user_role"]["name"] != 'Director') {
  header("Location: ../login/login.php");
}}
// Additional logic can be placed here if needed
