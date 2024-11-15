<?php 
session_start();
if ($_SESSION["user_role"]!='Staff'){
  header("Location: ../logout.php");
}
?>

<!DOCTYPE html>
<html lang="en-GB">

<head>
  <title>HMS :: Staff</title>
  <?php include('../../includes/header.php'); ?>

</head>


<body>
    <h1>Staff Dashboard</h1>
    <a href="../logout.php">logout</a>
</body>

</html>
