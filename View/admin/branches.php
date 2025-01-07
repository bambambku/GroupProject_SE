<?php
try {
    $db = new PDO('sqlite:' . __DIR__ . '/../../Model/Terra_Core_DB.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

// Switch case for each CRUD - Not all complete but a starting point for further development.
if (!empty($data) && isset($data['action'])) {
    $action = $data['action'];
    try {
        switch ($action) {

            case 'create':
                // Create a new branch
                try {
                    $db->beginTransaction();

                    $stmt = $db->prepare("INSERT INTO Branch (name, town, post_code)
                                          VALUES (:name, :town, :post_code)");
                    $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
                    $stmt->bindValue(':town', $data['town'], PDO::PARAM_STR);
                    $stmt->bindValue(':post_code', $data['post_code'], PDO::PARAM_STR);
                    $stmt->execute();

                    $db->commit();
                    echo json_encode(['success' => true]);
                } catch (Exception $e) {
                    $db->rollBack();
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                break;

            case 'read':
                // Read the list of branches with staff count
                if (isset($data['branchID'])) {
                    // Fetch a specific branch by ID, including staff count
                    $stmt = $db->prepare("
                        SELECT 
                            branch.ID AS branch_id, 
                            branch.name AS branch_name, 
                            branch.town, 
                            branch.post_code, 
                            COUNT(staff.staff_id) AS num_staff
                        FROM 
                            branch
                        LEFT JOIN staff ON branch.ID = staff.branch_id
                        WHERE branch.ID = :branchID
                        GROUP BY branch.ID
                    ");
                    $stmt->bindValue(':branchID', $data['branchID'], PDO::PARAM_INT);
                    $stmt->execute();
                    $branch = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($branch) {
                        echo json_encode($branch);
                    } else {
                        echo json_encode(['error' => 'Branch not found']);
                    }
                } else {
                    // Fetch all branches with staff count
                    $stmt = $db->prepare("
                        SELECT 
                            branch.ID AS branch_id, 
                            branch.name AS branch_name, 
                            branch.town, 
                            branch.post_code, 
                            COUNT(staff.staff_id) AS num_staff
                        FROM 
                            branch
                        LEFT JOIN staff ON branch.ID = staff.branch_id
                        GROUP BY branch.ID, branch.name, branch.town, branch.post_code
                    ");
                    $stmt->execute();
                    $branches = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($branches) {
                        echo json_encode($branches);
                    } else {
                        echo json_encode(['error' => 'No branches found']);
                    }
                }
                break;

            case 'update':
                // Update branch details
                try {
                    $db->beginTransaction();

                    $stmt = $db->prepare("UPDATE Branch SET 
                        name = :name, 
                        town = :town, 
                        post_code = :post_code
                        WHERE ID = :branchID");
                    $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
                    $stmt->bindValue(':town', $data['town'], PDO::PARAM_STR);
                    $stmt->bindValue(':post_code', $data['post_code'], PDO::PARAM_STR);
                    $stmt->bindValue(':branchID', $data['branchID'], PDO::PARAM_INT);
                    $stmt->execute();

                    $db->commit();
                    echo json_encode(['success' => true]);
                } catch (Exception $e) {
                    $db->rollBack();
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                break;

            case 'delete':
                // Delete a branch by ID
                try {
                    $db->beginTransaction();

                    
                    $stmt = $db->prepare("DELETE FROM staff WHERE branch_id = :branchID");
                    $stmt->bindValue(':branchID', $data['branchID'], PDO::PARAM_INT);
                    $stmt->execute();

                    // delete the branch
                    $stmt = $db->prepare("DELETE FROM Branch WHERE ID = :branchID");
                    $stmt->bindValue(':branchID', $data['branchID'], PDO::PARAM_INT);
                    $stmt->execute();

                    $db->commit();
                    echo json_encode(['success' => true]);
                } catch (Exception $e) {
                    $db->rollBack();
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                break;

            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
                break;
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No action specified']);
}
?>
