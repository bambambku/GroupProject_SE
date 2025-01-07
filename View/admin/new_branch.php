<?php
include ('../../includes/dbconnect.php');
include('../../includes/verify_user.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['name']) && isset($_POST['address']) && isset($_POST['post_code']) && isset($_POST['town'])) {

        $name = $_POST["name"];
        $address = $_POST["address"];
        $post_code = $_POST["post_code"];
        $town = $_POST["town"];
        

        // Check if the branch already exists in the database
        $sql_check = "SELECT COUNT(*) FROM branch WHERE post_code = :post_code";
        $stmt_check = $myPDO->prepare($sql_check);
        $stmt_check->bindParam(':post_code', $post_code, PDO::PARAM_STR);
        $stmt_check->execute();
        
        $branchExists = $stmt_check->fetchColumn();

        if ($branchExists > 0) {
            echo "There is already a branch with that post code. Please try again.";
            exit; // Stop further processing if branch exists
        }

        $sql = "INSERT INTO branch (name, address, post_code, town) 
                VALUES (:name, :address, :post_code, :town)";
        
        $stmt = $myPDO->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':post_code', $post_code, PDO::PARAM_STR);
        $stmt->bindParam(':town', $town, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Branch created successfully!";
        } else {
            echo "There was an error creating your branch.";
        }

    } else {
        echo "Missing required fields!";
    }

    exit;  // Ensure the rest of the page doesn't load after AJAX response
}

?>

<!DOCTYPE html>
<html lang="en-GB">
<head>
    <title>TerraCore :: Admin</title>
    <?php include('../../includes/header.php'); ?>
    <?php include ('../../includes/navbar.php'); ?>
    <script src="../../js/cssConverter.js"></script>
    <script src="../../js/verifyNewBranch.js"></script>

    <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)">
    <link rel="stylesheet" href="../../CSS/style-new-account.css" media="screen and (min-width: 1025px)">
    <script>updateCss("Admin");</script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="admin-background">
<div id="new-branch" class="section">
    <h1>Create New Branch</h1>
    <form id="newBranchForm" action="new_branch.php" method="post">
        <div class="form-container">
            <div class="column">
                <div class="form-group">
                    <label for="name">Branch Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="post_code">Post Code:</label>
                    <input type="text" id="post_code" name="post_code" required>
                </div>
                <div class="form-group">
                    <label for="town">Town:</label>
                    <input type="text" id="town" name="town" required>
                </div>
            </div>
        </div>

        <button type="submit" class="submit-btn" value="new-branch" name="new-branch">Submit</button>
    </form>
</div>
</body>
</html>


