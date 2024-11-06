<?php
include("db_connection.php");
// $db = new SQLite3("C:\\xampp\\htdocs\\assessment\\database\\Enigma.db");

function makeQuery ($sql, $db){
// $db = new SQLITE3('GET YOUR DB FILE PATH HERE!');
$stmt = $db->prepare($sql);
$result = $stmt->execute();
while ($row = $result->fetchArray()){ // use fetchArray(SQLITE3_NUM) - another approach
    $arrayResult [] = $row; //adding a record until end of records
    }
return $arrayResult;
}