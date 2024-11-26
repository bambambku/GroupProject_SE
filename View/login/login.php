<?php
session_start();
if (isset($_SESSION["user_role"])) {
    header("Location: logout.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Terra Core :: Login</title>
  <?php include('../../includes/header.php'); ?>
  <link rel="stylesheet" href="..\..\CSS\login.css">
</head>
<body class="background1">
        <div class="logo-container">
            <img src="../../Pictures\logo.png" alt="Logo" class="logo-pic">
        </div>
        <div class="login-container-background-out">
            <div class="login-container-background-ins">
                <div class="login-container">
                <?php
                if (isset($_POST["login"])) {
                    $email_address = $_POST["email"];
                    $password = $_POST["password"];
                
                    require_once "../../includes/dbconnect.php";
                
                    // Debugging: Check if connection is working
                    if (!$myPDO) {
                        die("Database connection failed: " . implode(":", $myPDO->errorInfo()));
                    }
                  
                    // Test with a simpler query
                    try {
                        $sql = "SELECT * FROM Staff WHERE email = :email";  // Adjust column name if needed
                        $stmt = $myPDO->prepare($sql);
                        $stmt->bindParam(':email', $email_address, PDO::PARAM_STR);
                        $stmt->execute();



                        // Checking if the statement prepared properly / isn't empty
                        if ($stmt) {
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($user) {
                                if ($password == $user["password"]) {

                                  
                                    $_SESSION['user_role'] = $user['role_id'];
                                    $_SESSION['user_firstName'] = $user['f_name'];
                                    $_SESSION['user_surname'] = $user['l_name'];
                                    $_SESSION['email_address'] = $user['email'];
                                    $_SESSION['user_id'] = $user['staff_id'];

                                    // In this section here: it makes more sense to have user
                                    // role stored as the actual role title rather than a number.
                                    // You'd either have to accept it's redundant or change it.
                                    if ($user['role_id'] == 1) {
                                        header("Location: ../employee/Employee.php"); // change this to correct path
                                    } elseif ($user['role_id'] == 2) {
                                        header("Location: ../director/products.php"); // The only reason this takes you to a director's page is because we're in the process of moving things around.
                                    } elseif ($user['role_id'] == 'Manager') {
                                        header("Location: ../manager/m_home.php");
                                    } elseif ($user['role_id'] == 'Stock Manager') {
                                        header("Location: ../stock_manager/sm_home.php");
                                    } else {
                                        echo $user['role_id'];
                                    }
                                    die();
                                } else {
                                    echo "<p class='error_message'>Invalid Email or Password</p>";
                                }
                            } else {
                                echo "<p class='error_message'>Invalid Email or Password</p>";
                            }
                        } else {
                            echo "Error with the SQL query: " . implode(":", $myPDO->errorInfo());
                        }
                    } catch (PDOException $e) {
                        echo "PDO Error: " . $e->getMessage();
                    }
                }
                ?>

                <form action="login.php" method="post">
                  <input type="email" name="email" placeholder="Email Address" required>
                  <input type="password" name="password" placeholder="Password" required>
                  <input type="submit" value="Login" name="login">

                  <!-- Forgot Password link -->
                  <a href="" class="forgot-password">Forgot Password?</a>
                </form>
                </div>
            </div>
        </div>
</body>
</html>


<!-- 

######## Login info - {Delete when submitting} ########
{This is just for everyone who is testing their pages}

__________________________________________________________________
| Email                     | Password | Role          | Role ID |
==================================================================
| lhattersley@terracore.com |   1234   | Employee      |    1    |
------------------------------------------------------------------
| cstarling@terracore.com   |   1234   | Stock Manager |    2    |
------------------------------------------------------------------
| mobrycki@terracore.com    |   1234   | Manager       |    3    |
------------------------------------------------------------------
| skovacs@terracore.com     |   1234   | Director      |    4    |
------------------------------------------------------------------
| jfrancois@terracore.com   |   1234   | Admin         |    5    |
------------------------------------------------------------------

Wireframe Link [ https://rp.mockplus.com/editor/4p5Fn3_WL/2SNRE91EZy ]

-->