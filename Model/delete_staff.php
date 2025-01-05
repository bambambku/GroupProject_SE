<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include your database connection
include('../includes/dbconnect.php');

// Get the raw data from the request body
$data = json_decode(file_get_contents("php://input"));

// Log the incoming data to the error log for debugging
error_log("Received data: " . print_r($data, true));

// Ensure the staffId is provided
if (!$data || !isset($data->staffId)) {
    echo json_encode(['failure' => true, 'message' => 'staffId is required']);
    exit();
}

$staffId = $data->staffId;

// Ensure the staffId is valid (basic validation)
if (!is_numeric($staffId)) {
    echo json_encode(['failure' => true, 'message' => 'Invalid staff ID']);
    exit();
}

try {
    // Prepare the SQL DELETE statement
    $query = "DELETE FROM Staff WHERE staff_id = :staff";

    if ($stmt = $myPDO->prepare($query)) {
        $stmt->bindParam(':staff', $staffId, PDO::PARAM_INT);
        // Bind the staffId to the prepared statement

        // Execute the query
        if ($stmt->execute()) {
            // If successful, send a success response
            echo json_encode(['failure' => false, 'message' => 'Staff member deleted successfully']);
        } else {
            // If execution failed, send an error response
            echo json_encode(['failure' => true, 'message' => 'Failed to execute DELETE statement']);
        }

    } else {
        // If the statement preparation fails, return an error
        echo json_encode(['failure' => true, 'message' => 'Failed to prepare SQL statement']);
    }

} catch (Exception $e) {
    // Catch any exceptions and return an error message
    echo json_encode(['failure' => true, 'message' => 'Error: ' . $e->getMessage()]);
}
