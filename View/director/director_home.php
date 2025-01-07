<?php 
 include ('../../includes/header.php');
 include '../../includes/navbar.php'; 
 include('../../includes/verify_user.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="..\..\CSS\director.css">
    <link rel="stylesheet" href="../../CSS/style-desktop.css">
    <script src="../../js/cssConverter.js"></script>
    <script>updateCss("Director");</script>
    <title>Director :: Home</title>
</head>
<body class="director-background">
    <main class="main-container">
        
    <div class="director-content-out">
        <h1 id = "greetingdirector"></h1>
        <h2>Branch Name</h2>
        <div class="director-home-wrapper">
        <div class="graph-container">
            <div class="graph-labels">
                <div class="graph-label">£50,000</div>
                <div class="graph-label">£40,000</div>
                <div class="graph-label">£30,000</div>
                <div class="graph-label">£20,000</div>
                <div class="graph-label">£0,00</div>
            </div>
            <div class="graph-bar-wrapper">
                <div class="graph-bar graph-bar1"></div>
                <div class="graph-label-bottom">Income</div>
            </div>
            <div class="graph-bar-wrapper">
                <div class="graph-bar graph-bar2"></div>
                <div class="graph-label-bottom">Wages</div>
            </div>
            <div class="graph-bar-wrapper">
                <div class="graph-bar graph-bar3"></div>
                <div class="graph-label-bottom">Stock</div>
            </div>
            <div class="graph-bar-wrapper">
                <div class="graph-bar graph-bar4"></div>
                <div class="graph-label-bottom">Profit</div>
            </div>
        </div>
        <div class="piechart-wrap">
            <div class="pie"></div> 
            <ul class="ul-piename"> 
                <li><span class="color intel-st"></span> Intel Based: 40%</li> 
                <li><span class="color amd-st"></span> AMD Based: 30%</li> 
                <li><span class="color mac-st"></span>Mac Based: 15%</li> 
                <li><span class="color other-st"></span> Other: 15%</li>    
            </div>
        </div>
        

        </div>
    </main>

    <!-- Simple greeting based on the time of the day -->
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
<?php include '../../includes/footer.php'; ?>
</html>

