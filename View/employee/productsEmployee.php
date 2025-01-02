<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// logout and redirect to login if user is not logged in or not an employee 
if ($_SESSION["user_role"] != 1) {
    if ($_SESSION["user_role"]["name"] != 'Employee') {
    header("Location: ../login/login.php");
}}

include ("../../query.php");
if(!isset($_SESSION['branch_id'])) {
    $_SESSION['branch_id'] = 1;
}
$currentBranch = $_SESSION['branch_id'];

$sql = "SELECT * FROM Product LEFT JOIN stock ON Product.ID = stock.product WHERE stock.branch = :branch";
$params = ['branch' => $currentBranch];

// Execute the query using PDO
$stmt = $myPDO->prepare($sql);
$stmt->execute($params);

include("../../includes/header2.php");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)">
    <link rel="stylesheet" href="..\..\CSS\stockManager.css">
    <title>Product View</title>
    <script defer src="../../js/tableDropSort.js"></script>
    <script defer src="../../js/productActions.js"></script>
</head>
<body id="stock-manager-background">
<?php include '../../includes/navbar.php'; ?>
<main class="main-container">
<div class="general-content-out">
    <!-- <div class="general-content-bttn-area">
    </div>
    <div class="general-content-in">     
        </div> -->
        <h1>Products:</h1>
        <table id="laptopTable">
            <thead>
                <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price (£)</th>
                <th>Weight</th>
                <th>Size</th>
                <th>CPU</th>
                <th>GPU</th>
                <th>RAM</th>
                <th>Hard Drive</th>
                <th>Stock</th>
            </tr>
        </thead>
            <tbody>
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['weight'] . "</td>";
                echo "<td>" . $row['size'] . "</td>";
                echo "<td>" . $row['CPU'] . "</td>";
                echo "<td>" . $row['GPU'] . "</td>";
                echo "<td>" . $row['RAM'] . "</td>";
                echo "<td>" . $row['hard_drive'] . "</td>";
                echo "<td>" . ($row['quantity'] ? $row['quantity'] : '0') . "</td>";
            }
            ?>
            </tbody>
        </table>
        </div>
    </div>            
</div>
</main>
<?php
include '../../includes/footer.php';
?>
</body>
</html>

