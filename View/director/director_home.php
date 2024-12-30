<?php 
 include('director_home_logic.php'); 
 include ('../../includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../CSS/style-director.css">
    <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)">
    <title>Director :: Home</title>
</head>
<body>
    <?php include '../../includes/navbar.php'; ?>
    <main class="main-container">
        <h1>Welcome, Director!</h1>
        <p>Use the navigation below to access different sections of the dashboard.</p>
        <ul class="dashboard-nav">
            <li><a href="director_report.php">Generate Report</a></li>
            <li><a href="report.php">Report Page</a></li>
            
        </ul>
    </main>
    <?php include '../../includes/footer.php'; ?>
</body>
</html>

