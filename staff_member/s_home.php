<?php 
session_start();
if ($_SESSION["user_role"]!='Staff'){
  header("Location: ../View/logout.php");
}
?>

<!DOCTYPE html>
<html lang="en-GB">

<head>
  <title>HMS :: Staff</title>
  <?php include('../includes/header.php'); ?>

</head>


<body>
    <h1>Staff Dashboard</h1>
    <a href="../View/logout.php">logout</a>
</body>

</html>
