<?php 
session_start();
if ($_SESSION["user_role"]!=5){
  header("Location: ../login/logout.php");
}
?>
<!-- bg colour #224F59-->



<!DOCTYPE html>
<html lang="en-GB">

<head>
  <title>TerraCore :: Admin</title>
  <?php include('../../includes/header.php'); ?>
  <?php include ('../../includes/navbar.php'); ?>
  <script src="../../js/cssConverter.js"></script>
  <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)">
  <script>updateCss("Admin");</script>
</head>


<body class="admin-background">
  <div class="section">
  </div>
</body>

</html>
