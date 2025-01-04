<?php
include ("../../includes/dbconnect.php");

$report = [];
$overall_income = 0;
$most_sold_product = null;
$least_sold_product = null;
$top_selling_employee = null;
$dateErr = $errMsg = "";
$isDateValid = true;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["generate_report"])) 

{
    $branch_id = $_POST["branch"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $currentdate = date("Y-m-d");

    // Checking validations against dates in the future also against date before the selected date
    if ($start_date > $currentdate || $end_date > $currentdate) 
    
    {
        $dateErr = "Dates cannot be in the future.";
        $isDateValid = false;
    } elseif ($start_date > $end_date) 
    
    {
        $dateErr = "Start date cannot be after end date.";
        $isDateValid = false;
    }

    if ($isDateValid) 
    
    {
        // Get income, most sold products, and employee sales from the database
        $stmt = $myPDO->prepare("SELECT 
                                    SUM(Sale.quantity * Product.price) as income, 
                                    Product.name, 
                                    SUM(Sale.quantity) as total_sold,
                                    Staff.staff_id,
                                    Staff.f_name,
                                    Staff.l_name,
                                    SUM(Sale.quantity * Product.price) as total_income
                                  FROM Sale
                                  JOIN Product ON Sale.product = Product.ID 
                                  JOIN Staff ON Sale.user = Staff.staff_id 
                                  WHERE Staff.branch_id = :branch_id 
                                  AND Sale.time_date BETWEEN :start_date AND :end_date
                                  GROUP BY Product.name, Staff.staff_id, Staff.f_name, Staff.l_name
                                  ORDER BY total_sold DESC");
        $stmt->bindValue(':branch_id', $branch_id, PDO::PARAM_INT);
        $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
        $stmt->bindValue(':end_date', $end_date, PDO::PARAM_STR);
        $stmt->execute();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
        
        {
            $report[] = $row;
            $overall_income += $row['income'];
        }

        // Logic for the most product sold by one employee 
        if (!empty($report)) {
            $most_sold_product = $report[0];
            $least_sold_product = $report[count($report) - 1];

            // Find the employee with the highest sales
            $top_selling_employee = $report[0];
            foreach ($report as $record) {
                if ($record['total_income'] > $top_selling_employee['total_income']) 
                
                {
                    $top_selling_employee = $record;
                }
            }
        }

        // Serialize data for passing to view_report.php
        $data = [
            'branch_id' => $branch_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'report' => serialize($report),
            'overall_income' => $overall_income,
            'most_sold_product' => serialize($most_sold_product),
            'least_sold_product' => serialize($least_sold_product),
            'top_selling_employee' => serialize($top_selling_employee)
        ];

        // Redirect to view_report.php with serialized data
        $query = http_build_query($data);
        header("Location: view_report.php?$query");
        exit();
    } else 
    
    {
        // Handle validation errors by setting error messages to be displayed on report.php page
        $errMsg = $dateErr;
        header("Location: report.php?errMsg=" . urlencode($errMsg));
        exit();
    }
}
?>

