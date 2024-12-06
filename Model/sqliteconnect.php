<?php

$db = new SQLite3("C:\xampp\htdocs\GroupProject_SE\View\stockManager\Terra_Core_DB.db"); // CREATE A PATH TO THE DATABASE FILE (Terra_Core_DB.db)
if (!$db){
echo "Fail to connect the database";
}
$errorMessage = "Wrong data entered";

?>