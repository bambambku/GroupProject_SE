<?php 
if (session_status() === PHP_SESSION_NONE){
  session_start();
}

if ($_SESSION["user_role"]!=5){
  header("Location: ../login/logout.php");
}
?>

<!DOCTYPE html>
<html lang="en-GB">

<head>
  <title>TerraCore :: Admin</title>
  <?php include('../../includes/header.php'); ?>
  <?php include ('../../includes/navbar.php'); ?>
  <script src="../../js/cssConverter.js"></script>
  <script defer src="../../js/staffActions.js"></script>

  <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)">
  <script>updateCss("Admin");</script>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>

<div id="modalWindowStaff" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Are you sure you want to delete this staff member?</h2>
        <div id="modalButtons">
            <button onclick="cancelDelete()">Cancel</button>
            <button onclick="deleteUser()">Delete</button>
        </div>
    </div>
</div>

<body class="admin-background">
  <div class="section">
    <h1>User Details</h1>
    <?php 
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
    ?>
<table class="table table-striped table-bordered" id="user-table">
    <thead>
        <tr>
            <th>Staff ID</th>
            <th>Branch</th>
            <th>Staff Member</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($staff_members) {
            foreach ($staff_members as $staff) {
                echo "<tr>";
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
        ?>
    </tbody>
</table>

    
  </div>
</body>

</html>


