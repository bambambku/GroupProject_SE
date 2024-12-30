<?php
include ("../../includes/dbconnect.php");

// Fetch report data based on selected branch and time frame
$report = [];
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["generate_report"])) {
    $branch_id = $_POST["branch"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    
    // Fetch income and most sold products
    $stmt = $db->prepare("SELECT 
                            SUM(order_amount) as income, 
                            product.name, 
                            SUM(order_details.quantity) as total_sold
                          FROM Orders 
                          JOIN order_details ON Orders.id = order_details.order_id 
                          JOIN product ON order_details.product_id = product.ID 
                          WHERE Orders.branch_id = :branch_id 
                          AND Orders.date BETWEEN :start_date AND :end_date
                          GROUP BY product.name
                          ORDER BY total_sold DESC");
    $stmt->bindValue(':branch_id', $branch_id, SQLITE3_INTEGER);
    $stmt->bindValue(':start_date', $start_date, SQLITE3_TEXT);
    $stmt->bindValue(':end_date', $end_date, SQLITE3_TEXT);
    $result = $stmt->execute();
    
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $report[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../CSS/style-director.css">
    <title>Director :: Report</title>
</head>
<body>
    <?php include '../../includes/navbar.php'; ?>
    <main class="main-container">
        <h1>Generate Report:</h1>
        <form method="post" action="director_report.php">
            <label for="branch">Select Branch:</label>
            <select id="branch" name="branch">
                <?php foreach ($branches as $branch): ?>
                    <option value="<?php echo htmlspecialchars($branch['ID']); ?>"><?php echo htmlspecialchars($branch['name']); ?></option>
                <?php endforeach; ?>
            </select><br>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required><br>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required><br>
            <input type="submit" name="generate_report" value="Generate Report">
        </form>
        <?php if (!empty($report)): ?>
        <h2>Report</h2>
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
        <?php endif; ?>
    </main>
    <?php include '../../includes/footer.php'; ?>
</body>
</html>

