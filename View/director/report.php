<?php
 include ('../../includes/header.php');
 include ('../../includes/dbconnect.php');
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
            <div class="director-content-in">
                <h1>Generate Report:</h1>
                <form method="post" action="logic_report.php">
                    <label for="branch">Select Branch:</label>
                    <select id="branch" name="branch" required>
                        
                        <?php
                        $branches = $myPDO->query("SELECT ID, name FROM Branch");

                        while ($branch = $branches->fetch(PDO::FETCH_ASSOC)) 
                        
                        {
                            echo '<option value="' . htmlspecialchars($branch['ID']) . '">' . htmlspecialchars($branch['name']) . '</option>';
                        }
                        ?>
                    </select><br>
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" required><br>
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date" required><br>
                    <input class="directorbttn" type="submit" name="generate_report" value="Generate Report">
                </form>

                <?php if (!empty($_GET['errMsg'])): ?>
                    <p class="error"><?php echo htmlspecialchars($_GET['errMsg']); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include '../../includes/footer.php'; ?>
</body>
</html>

