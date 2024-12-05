<?php
// Database connection as a PDO:
session_start();
$myPDO = new PDO('sqlite:' . __DIR__ . '/../Model/Terra_Core_DB.db');
// Relies on Terra_Core_DB.db file (SQLite3 Database)
?>