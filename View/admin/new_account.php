<?php
include ('../../includes/dbconnect.php');
include('../../includes/verify_user.php');

// Process the form submission (AJAX)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Check if all required fields are set
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['fname']) && isset($_POST['sname']) && isset($_POST['branchId']) && isset($_POST['role'])) {

        // Sanitize and assign POST data
        $email = $_POST["email"];
        $pass = $_POST["password"];
        $fname = $_POST["fname"];
        $sname = $_POST["sname"];
        $branchId = $_POST["branchId"];
        $roleId = $_POST["role"];

        // Check if the email already exists in the database
        $sql_check = "SELECT COUNT(*) FROM staff WHERE email = :email";
        $stmt_check = $myPDO->prepare($sql_check);
        $stmt_check->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_check->execute();
        
        // Fetch the count of emails found
        $emailExists = $stmt_check->fetchColumn();

        if ($emailExists > 0) {
            echo "The email address is already in use. Please choose a different one.";
            exit; // Stop further processing if email exists
        }

        // Proceed with inserting the new user if email is unique
        $sql = "INSERT INTO staff (email, password, f_name, l_name, branch_id, role_id) 
                VALUES (:email, :password, :firstname, :surname, :branch_id, :role_id)";
        
        $stmt = $myPDO->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $fname, PDO::PARAM_STR);
        $stmt->bindParam(':surname', $sname, PDO::PARAM_STR);
        $stmt->bindParam(':branch_id', $branchId, PDO::PARAM_INT);
        $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            echo "Account created successfully!";
        } else {
            echo "There was an error creating your account.";
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
    <script src="../../js/verifyNewAccount.js"></script>
    <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)">
    <link rel="stylesheet" href="../../CSS/style-new-account.css" media="screen and (min-width: 1025px)">
    <script>updateCss("Admin");</script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="admin-background">
<div id="new-account" class="section">
    <h1>Create New Account</h1>
    <form id="registrationForm" action="new_account.php" method="post">
        <div class="form-container">
            <!-- Left Column -->
            <div class="column">
                <div class="form-group">
                    <label for="fname">Firstname:</label>
                    <input type="text" id="fname" name="fname" required>
                </div>
                <div class="form-group">
                    <label for="sname">Surname:</label>
                    <input type="text" id="sname" name="sname" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="email-confirm">Re-enter Email:</label>
                    <input type="email" id="email-confirm" name="email-confirm" required>
                </div>
            </div>

            <!-- Right Column -->
            <div class="column">
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="password-confirm">Re-enter Password:</label>
                    <input type="password" id="password-confirm" name="password-confirm" required>
                </div>
                <div class="form-group">
                    <label for="branchId">Branch:</label>
                    <select id="branchId" name="branchId">
                        <?php 
                        $sql = "SELECT ID, name FROM Branch;";
                        $stmt = $myPDO->prepare($sql);
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            echo "<option value='".$row['ID']."'>".$row['name']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="role">User Role:</label>
                    <select id="role" name="role">
                        <?php 
                        $sql = "SELECT ID, name FROM Role;";
                        $stmt = $myPDO->prepare($sql);
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            echo "<option value='".$row['ID']."'>".$row['name']."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn" value="new-user" name="new-user">Submit</button>
    </form>
</div>
</body>
</html>
