<?php 
session_start();
if ($_SESSION["user_role"]!='Stock Manager'){
  header("Location: ../View/logout.php");
}
?>

<!DOCTYPE html>
<html lang="en-GB">

<head>
  <title>HMS :: Stock Manager</title>
  <?php include('../includes/header.php'); ?>

</head>


<body>
    <h1>Stock Manager Dashboard</h1>
    <a href="../View/logout.php">logout</a>
</body>

</html>
