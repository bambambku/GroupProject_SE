<?php 
session_start();
if ($_SESSION["user_role"]!='Manager'){
  header("Location: ../View/logout.php");
}
?>

<!DOCTYPE html>
<html lang="en-GB">

<head>
  <title>HMS :: Manager</title>
  <?php include('../includes/header.php'); ?>

</head>


<body>
    <h1>Manager Dashboard</h1>
    <a href="../View/logout.php">logout</a>
</body>

</html>
