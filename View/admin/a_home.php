<?php 
session_start();
if ($_SESSION["user_role"]!=5){
  header("Location: ../login/logout.php");
}
?>

<!DOCTYPE html>
<html lang="en-GB">

<head>
  <title>HMS :: Admin</title>
  <?php include('../../includes/header.php'); ?>

</head>


<body>
    <h1>Admin Dashboard</h1>
    <a href="../login/logout.php">logout</a>
</body>

</html>
