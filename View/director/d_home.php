<?php 
session_start();
if ($_SESSION["user_role"]!=4){
  header("Location: ../login/logout.php");
}
?>

<!DOCTYPE html>
<html lang="en-GB">

<head>
  <title>TerraCore :: Director</title>
  <?php include('../../includes/header.php'); ?>
  <?php include ('../../includes/navbar.php'); ?>
  <script src="../../js/cssConverter.js"></script>
  <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)">
  <script>updateCss("Director");</script>

</head>

<!-- Example page only, replace with joe's -->

<body>
    
</body>

</html>
