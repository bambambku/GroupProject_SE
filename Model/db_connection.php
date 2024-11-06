<?php

$db = new SQLite3(".\\Model\\inventory_management_system.db");
if (!$db){
echo "Fail to connect the database";
}

?>