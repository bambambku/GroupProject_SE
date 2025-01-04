<?php

$db = new SQLite3("C:\\xampp\\htdocs\\"); // CREATE A PATH TO THE DATABASE FILE (Terra_Core_DB.db)
if (!$db){
echo "Fail to connect the database";
}
$errorMessage = "Wrong data entered";

?>