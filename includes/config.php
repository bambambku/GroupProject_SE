<?php

$hostname= "localhost";
$dbuser="root";
$dbPassword = "";
$dbName = "ims";
$conn = mysqli_connect($hostname, $dbuser, $dbPassword, $dbName);
if(!$conn){
    die("Something went wrong");
}

?>

