<?php

$db = new SQLite3("Terra_Core_DB.db");
if (!$db){
echo "Fail to connect the database";
}
$errorMessage = "Wrong data entered";
?>