<?php
try {
    $db = new PDO('sqlite:' . __DIR__ . '/../../Model/Terra_Core_DB.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

//Switch case for each CRUD operation + Details Window + Sort
if (!empty($data) && isset($data['action'])) {
    $action = $data['action'];
    try {
        switch ($action) {

            case 'create':
                try {
                    $db->beginTransaction();

                    $stmt = $db->prepare("INSERT INTO Staff (f_name, l_name, email, phone, role_id, branch_id)
                                          VALUES (:f_name, :l_name, :email, :phone, :role_id, :branch_id)");
                    $stmt->bindValue(':f_name', $data['f_name'], PDO::PARAM_STR);
                    $stmt->bindValue(':l_name', $data['l_name'], PDO::PARAM_STR);
                    $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
                    $stmt->bindValue(':phone', $data['phone'], PDO::PARAM_STR);
                    $stmt->bindValue(':role_id', $data['role_id'], PDO::PARAM_INT);
                    $stmt->bindValue(':branch_id', $data['branch_id'], PDO::PARAM_INT);
                    $stmt->execute();

                    $staffID = $db->lastInsertId();
                    $db->commit();
                    echo json_encode(['success' => true]);
                } catch (Exception $e) {
                    $db->rollBack();
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                break;

            case 'read':
                if (isset($data['staffID'])) {
                    $stmt = $db->prepare("SELECT staff.staff_id, staff.f_name || ' ' || staff.l_name AS full_name, 
                                              branch.name AS branch_name, role.name AS role_name
                                              FROM staff
                                              JOIN branch ON staff.branch_id = branch.ID
                                              JOIN role ON staff.role_id = role.ID
                                              WHERE staff.staff_id = :staffID");
                    $stmt->bindValue(':staffID', $data['staffID'], PDO::PARAM_INT);
                    $stmt->execute();
                    $staff = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($staff) {
                        echo json_encode($staff);
                    } else {
                        echo json_encode(['error' => 'Staff not found']);
                    }
                } else {
                    $stmt = $db->prepare("SELECT staff.staff_id, staff.f_name || ' ' || staff.l_name AS full_name, 
                                              branch.name AS branch_name, role.name AS role_name
                                              FROM staff
                                              JOIN branch ON staff.branch_id = branch.ID
                                              JOIN role ON staff.role_id = role.ID");
                    $stmt->execute();
                    $staffMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($staffMembers) {
                        echo json_encode($staffMembers);
                    } else {
                        echo json_encode(['error' => 'No staff members found']);
                    }
                }
                break;

            case 'update':
                try {
                    $db->beginTransaction();

                    $stmt = $db->prepare("UPDATE Staff SET 
                        f_name = :f_name, 
                        l_name = :l_name, 
                        email = :email, 
                        phone = :phone, 
                        role_id = :role_id, 
                        branch_id = :branch_id
                        WHERE staff_id = :staffID");
                    $stmt->bindValue(':f_name', $data['f_name'], PDO::PARAM_STR);
                    $stmt->bindValue(':l_name', $data['l_name'], PDO::PARAM_STR);
                    $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
                    $stmt->bindValue(':phone', $data['phone'], PDO::PARAM_STR);
                    $stmt->bindValue(':role_id', $data['role_id'], PDO::PARAM_INT);
                    $stmt->bindValue(':branch_id', $data['branch_id'], PDO::PARAM_INT);
                    $stmt->bindValue(':staffID', $data['staffID'], PDO::PARAM_INT);
                    $stmt->execute();

                    $db->commit();
                    echo json_encode(['success' => true]);
                } catch (Exception $e) {
                    $db->rollBack();
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                break;

            case 'delete':
                $stmt = $db->prepare("DELETE FROM Staff WHERE staff_id = :staffID");
                $stmt->bindValue(':staffID', $data['staffID'], PDO::PARAM_INT);
                $stmt->execute();
                echo json_encode(['success' => true]);
                break;

            case 'sort':
                $orderBy = '';
                switch ($data['sortOption']) {
                    case 'nameAsc':
                        $orderBy = 'staff.f_name ASC';
                        break;
                    case 'nameDesc':
                        $orderBy = 'staff.f_name DESC';
                        break;
                    case 'role':
                        $orderBy = 'role.name ASC';
                        break;
                    default:
                        $orderBy = 'staff.f_name ASC';
                        break;
                }
                $stmt = $db->prepare("SELECT staff.staff_id, staff.f_name || ' ' || staff.l_name AS full_name, 
                                      branch.name AS branch_name, role.name AS role_name
                                      FROM staff
                                      JOIN branch ON staff.branch_id = branch.ID
                                      JOIN role ON staff.role_id = role.ID
                                      ORDER BY $orderBy");
                $stmt->execute();
                $staffMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($staffMembers);
                break;

            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
                break;
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    try {
        $stmt = $db->query("SELECT staff.staff_id, staff.f_name || ' ' || staff.l_name AS full_name, 
                            branch.name AS branch_name, role.name AS role_name
                            FROM staff
                            JOIN branch ON staff.branch_id = branch.ID
                            JOIN role ON staff.role_id = role.ID");
        $staffMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $staffMembers = [];
    }
    include("access_users.php");
}
?>
