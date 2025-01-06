<?php
include ('../../includes/dbconnect.php');

include('../../includes/verify_user.php');

?>

<!DOCTYPE html>
<html lang="en-GB">

<head>
  <title>TerraCore :: Admin</title>
  <?php include('../../includes/header.php'); ?>
  <?php include ('../../includes/navbar.php'); ?>
  <script src="../../js/cssConverter.js"></script>

  <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)">
  <script>updateCss("Admin");</script>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script defer src="../../js/staffActions.js"></script>

</head>

<div id="modalWindowStaff" class="modal">
    <div class="modal-content">
    <button type="button" id="closeButton">Close</button>
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
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          echo "<tr>";
          echo "<td>" . $row['staff_id'] . "</td>";
          echo "<td>" . $row['branch_name'] . "</td>";
          echo "<td>" . $row['full_name'] . "</td>";
          echo "<td>" . $row['role_name'] . "</td>";
          echo "<td>" . 
            "<button onclick ='viewRecord(". htmlspecialchars($row['staff_id']) .")'>View</button>" .
            "<button id='deleteButton" . $row['staff_id'] . "' class='delete-button'>Delete</button>" .  
            "</td>";
          echo "</tr>";
        }
        ?>
    </tbody>
</table>

</div>
</body>

</html>


