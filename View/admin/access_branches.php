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
  <script>updateCss("Admin");</script>
  <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)">
  
  <script defer src="../../js/branchActions.js"></script>

</head>

<div id="modalWindowBranches" class="modal">
    <div class="modal-content">
    <button type="button" id="closeButton">Close</button>
    <h2 id="modalTitle">Are you sure you want to delete this branch?</h2>
        <div id="modalButtons">
            <button onclick="cancelDelete()">Cancel</button>
            <button onclick="deleteUser()">Delete</button>
        </div>
    </div>
</div>

<body class="admin-background">
  <div class="section">
    <h1>Branch Details</h1>
    <table class="table table-striped table-bordered" id="branches-table">
    <thead>
        <tr>
            <th>Branch ID</th>
            <th>Name</th>
            <th>Town</th>
            <th>Postal Code</th>
            <th>Number of Staff</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Updated SQL query to get the number of staff per branch
        $sql = "
        SELECT 
            branch.ID, 
            branch.name AS branch_name, 
            branch.town, 
            branch.post_code, 
            COUNT(staff.staff_id) AS num_staff
        FROM 
            branch
        LEFT JOIN 
            staff ON branch.ID = staff.branch_id
        GROUP BY 
            branch.ID;
        ";

        $stmt = $myPDO->prepare($sql);
        $stmt->execute();

        // Loop through the results and fill the table
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['ID'] . "</td>";
            echo "<td>" . $row['branch_name'] . "</td>";
            echo "<td>" . $row['town'] . "</td>";
            echo "<td>" . $row['post_code'] . "</td>";
            echo "<td>" . $row['num_staff'] . "</td>"; // Display the number of staff
            echo "<td>" . 
            "<button id='deleteButton" . $row['ID'] . "' class='delete-button'>Delete</button>" .  
            "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

</div>
</body>

</html>


