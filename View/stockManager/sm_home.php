<?php 
session_start();
if ($_SESSION["user_role"]!=2){
  header("Location: ../logout.php");
}
?>

<!DOCTYPE html>
<html lang="en-GB">

<head>
  <title>TerraCore :: Stock Manager</title>
  <?php include('../../includes/header.php'); ?>

</head>

<!-- Example page only, replace with joe's -->

<body>
    <h1>Stock Manager Dashboard</h1>
    <p> This is an example page that needs changing to fit Joe's new one.</p>
    <a href="../login/logout.php">logout</a>
</body>

</html>
