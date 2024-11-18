<?php
// Database connection as a PDO:
$myPDO = new PDO('sqlite:..\Model\Terra_Core_DB.db');

// Example of a Query:
$result = $myPDO->query("SELECT f_name FROM Staff");

// Example of result processing:
foreach($result as $row)
    {
        echo $row['f_name'] . "\n";
    }

?>