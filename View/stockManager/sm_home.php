<?php 
session_start();
if ($_SESSION["user_role"]!=4){
  header("Location: ../login/logout.php");
}
?>

<!DOCTYPE html>
<html lang="en-GB">

<head>
  <title>TerraCore :: Stock Manager</title>
  <?php include('../../includes/header.php'); ?>
  <?php include ('../../includes/navbar.php'); ?>
  <script src="../../js/cssConverter.js"></script>
  <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)">
  <script>updateCss("Director");</script>

</head>

<!-- Example page only, replace with joe's -->

<body>
    <h1>Stock Manager Dashboard</h1>
    <p> This is an example page that needs changing to fit Joe's new one.</p>
    <a href="../login/logout.php">logout</a>
</body>

</html>
