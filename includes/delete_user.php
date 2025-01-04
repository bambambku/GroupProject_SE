<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
        $userId = $_POST['user_id'];

        $query = "DELETE FROM Staff WHERE staff_id = :user_id";
        $stmt = $myPDO->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_STR);
        try {
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete user.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid user ID.']);
    }
} 
?>