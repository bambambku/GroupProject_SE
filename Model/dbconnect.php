<!-- <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_management_system_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?> -->


<?php

// HOSTED DATABASE CONNECTION (NOT IN USE YET!)
// https://dash.infinityfree.com/accounts/if0_37729593/databases
// password: Canabana333

$servername = "sql202.infinityfree.com";
$username = "if0_37729593";
$password = "5R2SczKl5opntYa";
$dbname = "if0_37729593_XXX";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>

