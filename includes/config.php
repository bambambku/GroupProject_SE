<?php
$hostname= "localhost";
$dbuser="root";
$dbPassword = "";
$dbName = "inventory_management_system_db";
$conn = mysqli_connect($hostname, $dbuser, $dbPassword, $dbName);
if(!$conn){
    die("Something went wrong");
}
?>

