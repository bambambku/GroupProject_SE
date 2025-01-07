
<?php
include('../../includes/dbconnect.php');

if (isset($_GET['staff_id'])) {
    $staff_id = $_GET['staff_id'];

    try {
        // Fetch staff data
        $stmt = $myPDO->prepare("SELECT * FROM staff WHERE staff_id = :staff_id");
        $stmt->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
        $stmt->execute();

        $staff = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch roles and branches for the dropdowns
        $rolesStmt = $myPDO->query("SELECT ID, name FROM Role");
        $roles = $rolesStmt->fetchAll(PDO::FETCH_ASSOC);

        $branchesStmt = $myPDO->query("SELECT ID, name FROM Branch");
        $branches = $branchesStmt->fetchAll(PDO::FETCH_ASSOC);

        if ($staff) {
            echo json_encode([
                'staff' => $staff,
                'roles' => $roles,
                'branches' => $branches
            ]);
        } else {
            echo json_encode(['error' => 'Staff not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Staff ID is missing']);
}
?>
