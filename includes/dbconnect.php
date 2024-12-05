<?php
// // Database connection as a PDO:
// $myPDO = new PDO('sqlite:' . __DIR__ . '/../Model/Terra_Core_DB.db');
// // Relies on Terra_Core_DB.db file (SQLite3 Database)
// 


try {
    $myPDO = new PDO('sqlite:' . __DIR__ . '/../Model/Terra_Core_DB.db');
    echo "Database connected successfully!<br>";
} catch (PDOException $e) {
    echo "Database connection error: " . $e->getMessage() . "<br>";
}


?>