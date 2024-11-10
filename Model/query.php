<?php
include("dbconnect.php");

function makeQuery ($sql, $conn){
    $arrayResult = [];
    $result = $conn->query($sql);
    if ($result){
        while ($row = $result->fetch_assoc()) {
            $arrayResult[] = $row; 
        }
    }
    else {
        echo "Error: " . $conn->error;
    }  
    return $arrayResult; 
}
