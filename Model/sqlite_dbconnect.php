<?php

$path = __DIR__ . "/Terra_Core_DB.db";
try {
    $conn = new SQLite3($path);
    $conn->exec('PRAGMA foreign_keys = ON;');
} catch (Exception $e) {
    die("Failed to connect to the database: " . $e->getMessage());
}
$errorMessage = "Wrong data entered";
?>