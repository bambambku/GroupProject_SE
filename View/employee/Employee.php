<?php
include ("../../includes/dbconnect.php");

session_start();
if ($_SESSION["user_role"]!=2) {
    header("Location: ../login/logout.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)">
    <link rel="stylesheet" href="../../CSS/employee.css" media="screen and (min-width: 1025px)">
</head>

<body id="employee-background">
<?php include '../../includes/navbar.php'; ?>
<main class="main-container">
        <div class="general-content-out">
                <div class="general-content-bttn-area"></div>
                <div class="general-content-in"></div>
        </div>
        </main>
        <?php include '../../includes/footer.php'; ?>
</body>

</html>