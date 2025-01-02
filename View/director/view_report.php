<?php
include ("../../includes/dbconnect.php");

$data = $_GET;
$branch_id = $data['branch_id'];
$start_date = $data['start_date'];
$end_date = $data['end_date'];
$report = $data['report'];
$overall_income = $data['overall_income'];
$most_sold_product = $data['most_sold_product'];
$least_sold_product = $data['least_sold_product'];

$branch_query = $myPDO->prepare("SELECT name FROM Branch WHERE ID = :branch_id");
$branch_query->bindValue(':branch_id', $branch_id, PDO::PARAM_INT);
$branch_query->execute();
$branch = $branch_query->fetch(PDO::FETCH_ASSOC);
$branch_name = $branch['name'];
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
            <div class+="director-content-in">
            <h2>Report</h2>
        <p><strong>Branch:</strong> <?php echo htmlspecialchars($branch_name); ?></p>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($start_date . " - " . $end_date); ?></p>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Total Sold</th>
                <th>Income</th>
            </tr>
            <?php foreach ($report as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['total_sold']); ?></td>
                    <td><?php echo htmlspecialchars($item['income']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <h3>Overall Income: <?php echo htmlspecialchars($overall_income); ?></h3>
        <?php if ($most_sold_product): ?>
            <p>Best Selling Product: <?php echo htmlspecialchars($most_sold_product['name']); ?>, <?php echo htmlspecialchars($most_sold_product['total_sold']); ?> sold</p>
        <?php endif; ?>
        <?php if ($least_sold_product): ?>
            <p>Least Selling Product: <?php echo htmlspecialchars($least_sold_product['name']); ?>, <?php echo htmlspecialchars($least_sold_product['total_sold']); ?> sold</p>
        <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include '../../includes/footer.php'; ?>
</body>
</html>
