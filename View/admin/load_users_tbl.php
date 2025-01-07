<?php 
function recallAndReplaceTable(){
    global $myPDO;
    if (!$myPDO) {
      die("Database connection failed: " . implode(":", $myPDO->errorInfo()));
    }
    $sql = "
    SELECT 
    staff.staff_id, 
    staff.f_name || ' ' || staff.l_name AS full_name, 
    branch.name AS branch_name, 
    role.name AS role_name
    FROM 
    staff
    JOIN 
    branch ON staff.branch_id = branch.ID
    JOIN 
    role ON staff.role_id = role.ID;
    ";
    $stmt = $myPDO->prepare($sql);
    $stmt->execute();
    $staff_members = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($staff_members) {
        foreach ($staff_members as $staff) {
            echo "<tr id='staff-row-".$staff['staff_id']."'>";
            echo "<td>" . htmlspecialchars($staff['staff_id']) . "</td>";
            echo "<td>" . htmlspecialchars($staff['branch_name']) . "</td>";
            echo "<td>" . htmlspecialchars($staff['full_name']) . "</td>";
            echo "<td>" . htmlspecialchars($staff['role_name']) . "</td>";
            echo "<td>" . 
              "<button onclick ='viewRecord(". htmlspecialchars($staff['staff_id']) .")'>View</button>" .
              "<button id='deleteButton" . htmlspecialchars($staff['staff_id']) . "' class='delete-button'>Delete</button>" .  
              "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4' class='text-center'>No staff members found</td></tr>";
    }
}
?>