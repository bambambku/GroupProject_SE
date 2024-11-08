<?php 
session_start();
if (isset($_SESSION["user_role"])){
  header("Location: ../s_home.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>HMS :: Login</title>
  <?php include('../includes/header.php'); ?>
  <style>
    form {
      position: relative;
    }

    .forgot-password {
      position: absolute;
      right: 0;
      bottom: -25px; /* Adjust as needed */
      font-size: 14px;
      text-decoration: none;
      color: #007bff;
    }

    .forgot-password:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body id="background1">
        <div class="logo-container">
            <img src="../Pictures\logo.png.png" alt="Logo" class="logo-pic">
        </div>
        <div class="login-container-background-out">
            <div class="login-container-background-ins">
                <div class="login-container">
                <?php 
                  if (isset($_POST["login"])){
                    $email_address = $_POST["email"];
                    $password = $_POST["password"];
                    require_once "../includes/config.php";
                    $sql = "SELECT * FROM users WHERE email = '$email_address'";
                    $email_result= mysqli_query($conn, $sql);
                    $user = mysqli_fetch_array($email_result, MYSQLI_ASSOC);
                    if($user){
                      if($password == $user["password"]){
                      session_start();

                      $_SESSION['user_role']=$user['role'];
                      $_SESSION['user_firstName']= $user['fname'];
                      $_SESSION['user_surname']=$user['sname'];
                      $_SESSION['email_address']=$user['email'];
                      $_SESSION['user_id']=$user['user_id'];
            
                      if ($user['role']=='Admin'){
                        header("Location: ../admin/a_home.php");
                      } elseif ($user['role']=='Staff'){
                        header("Location: ../staff_member/s_home.php");
                      } elseif ($user['role']=='Manager'){
                        header("Location: ../manager/m_home.php");
                      } elseif ($user['role']=='Stock Manager'){
                        header("Location: ../stock_manager/sm_home.php");
                      } else {
                        echo $user['role'];
                      }
                      die();
                      } else{
                        echo "<p class='error_message'>Invalid Email or Password</p>";
                      }
                      } else{
                        echo "<p class='error_message'>Invalid Email or Password</p>";
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
