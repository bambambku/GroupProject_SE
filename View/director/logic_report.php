<?php
include ("../../includes/dbconnect.php");

$report = [];
$overall_income = 0;
$most_sold_product = null;
$least_sold_product = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["generate_report"])) {
    $branch_id = $_POST["branch"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $currentdate = date("Y-m-d");
    if ($start_date > $currentdate || $end_date > $currentdate) {
        header("Location: report.php");
        exit();
    }
    

    // Fetch income and most sold products
    $stmt = $myPDO->prepare("SELECT 
                                SUM(Sale.quantity * Product.price) as income, 
                                Product.name, 
                                SUM(Sale.quantity) as total_sold
                              FROM Sale
                              JOIN Product ON Sale.product = Product.ID 
                              WHERE Sale.id = :branch_id 
                              AND Sale.time_date BETWEEN :start_date AND :end_date
                              GROUP BY Product.name
                              ORDER BY total_sold DESC");
    $stmt->bindValue(':branch_id', $branch_id, PDO::PARAM_INT);
    $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
    $stmt->bindValue(':end_date', $end_date, PDO::PARAM_STR);
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $report[] = $row;
        $overall_income += $row['income'];
    }

    // Determine the most and least sold products
    if (!empty($report)) {
        $most_sold_product = $report[0];
        $least_sold_product = $report[count($report) - 1];
    }

    // Serialize data for passing to the view page
    $data = [
        'branch_id' => $branch_id,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'report' => $report,
        'overall_income' => $overall_income,
        'most_sold_product' => $most_sold_product,
        'least_sold_product' => $least_sold_product
    ];

    // Redirect to view_report.php with serialized data
    $query = http_build_query($data);
    header("Location: view_report.php?$query");
    exit();
}
