<?php 
 include('director_home_logic.php'); 
 include ('../../includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="..\..\CSS\director.css">
    <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)">
    <title>Director :: Home</title>
</head>
<body class="director-background">
    <?php include '../../includes/navbar.php'; ?>
    <main class="main-container">
        
    <div class="director-content-out">
    <h1 id = "greetingdirector"></h1>
    <h2>Branch Name</h2>
        <div class="director-content-in">

        <p>Graphical report here</p>
        </div>
    </div>

    </main>
    <?php include '../../includes/footer.php'; ?>
    <script> function getGreeting() 
        { 
            const now = new Date(); const hour = now.getHours();
            let greeting; if (hour < 12) 
            { 
                greeting = "Good Morning Director!";
            } 
            else if (hour < 18) 
            { 
                greeting = "Good Afternoon Director!";
            } 
            else 
            { 
                greeting = "Good Evening Director!";
            } return greeting;
        } 
        document.getElementById('greetingdirector').innerText = getGreeting(); 
    </script>
</body>
</html>

