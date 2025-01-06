<?php
// Include the PDO database connection
include('../../includes/dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve POST data
    $staff_id = isset($_POST['staff_id']) ? $_POST['staff_id'] : '';
    $f_name = isset($_POST['f_name']) ? $_POST['f_name'] : '';
    $l_name = isset($_POST['l_name']) ? $_POST['l_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $role_id = isset($_POST['role_id']) ? $_POST['role_id'] : '';
    $branch_id = isset($_POST['branch_id']) ? $_POST['branch_id'] : '';

    // Validate data (example checks)
    if (empty($staff_id) || empty($f_name) || empty($l_name) || empty($email) || empty($role_id) || empty($branch_id)) {
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }

    try {
        // Prepare update query to save the new data
        $stmt = $myPDO->prepare("UPDATE staff SET 
                                f_name = :f_name, 
                                l_name = :l_name, 
                                email = :email, 
                                role_id = :role_id, 
                                branch_id = :branch_id 
                                WHERE staff_id = :staff_id");

        // Bind parameters to the prepared query
        $stmt->bindParam(':f_name', $f_name);
        $stmt->bindParam(':l_name', $l_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
        $stmt->bindParam(':branch_id', $branch_id, PDO::PARAM_INT);
        $stmt->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);

        // Execute the update query
        $stmt->execute();

        // Check if the row was updated
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No changes made or staff not found.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
