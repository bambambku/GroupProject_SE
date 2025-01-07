<?php
include ('../../includes/dbconnect.php');


$report = [];
$overall_income = 0;
$most_sold_product = null;
$least_sold_product = null;
$top_selling_employee = null;
$dateErr = $errMsg = "";
$isDateValid = true;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["generate_report"])) {
    $branch_id = $_POST["branch"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $currentdate = date("Y-m-d");

    // Checking validations against dates in the future also against date before the selected date
    if ($start_date > $currentdate || $end_date > $currentdate) {
        $dateErr = "Dates cannot be in the future.";
        $isDateValid = false;
    } elseif ($start_date > $end_date) {
        $dateErr = "Start date cannot be after end date.";
        $isDateValid = false;
    }

    if ($isDateValid) {
        // Separated Products and Staff as it had some problems when it was queried "Together".
        // Products were split up in strange ways.

        // Query for products
        $stmtProduct = $myPDO->prepare("SELECT 
                                        Product.name, 
                                        SUM(Sale.quantity) as total_sold,
                                        SUM(Sale.quantity * Product.price) as total_income
                                    FROM Sale
                                    JOIN Product ON Sale.product = Product.ID 
                                    WHERE Sale.time_date BETWEEN :start_date AND :end_date
                                    GROUP BY Product.name
                                    ORDER BY total_sold DESC");
        $stmtProduct->bindValue(':start_date', $start_date, PDO::PARAM_STR);
        $stmtProduct->bindValue(':end_date', $end_date, PDO::PARAM_STR);
        $stmtProduct->execute();
        
        while ($row = $stmtProduct->fetch(PDO::FETCH_ASSOC)) {
            $report[] = $row;
            $overall_income += $row['total_income'];
        }

        if (!empty($report)) {
            $most_sold_product = $report[0];
            $least_sold_product = $report[count($report) - 1];
        }

        // Query for staff
        $stmtStaff = $myPDO->prepare("SELECT 
                                        Staff.staff_id,
                                        Staff.f_name,
                                        Staff.l_name,
                                        SUM(Sale.quantity * Product.price) as total_income
                                    FROM Sale
                                    JOIN Product ON Sale.product = Product.ID 
                                    JOIN Staff ON Sale.user = Staff.staff_id 
                                    WHERE Staff.branch_id = :branch_id 
                                    AND Sale.time_date BETWEEN :start_date AND :end_date
                                    GROUP BY Staff.staff_id, Staff.f_name, Staff.l_name
                                    ORDER BY total_income DESC");
        $stmtStaff->bindValue(':branch_id', $branch_id, PDO::PARAM_INT);
        $stmtStaff->bindValue(':start_date', $start_date, PDO::PARAM_STR);
        $stmtStaff->bindValue(':end_date', $end_date, PDO::PARAM_STR);
        $stmtStaff->execute();
        
        $staffReport = [];
        while ($row = $stmtStaff->fetch(PDO::FETCH_ASSOC)) {
            $staffReport[] = $row;
        }

        if (!empty($staffReport)) {
            $top_selling_employee = $staffReport[0];
        }

        // Formatting below for '£' and two decimals as well
        foreach ($report as &$row) {
            $row['total_income'] = '£' . number_format($row['total_income'], 2);
        }

        if ($most_sold_product) {
            $most_sold_product['total_income'] = '£' . number_format($most_sold_product['total_income'], 2);
        }

        if ($top_selling_employee) {
            $top_selling_employee['total_income'] = '£' . number_format($top_selling_employee['total_income'], 2);
        }

        // Serialize data for passing to view_report.php
        $data = [
            'branch_id' => $branch_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'report' => serialize($report),
            'overall_income' => '£' . number_format($overall_income, 2),
            'most_sold_product' => serialize($most_sold_product),
            'least_sold_product' => serialize($least_sold_product),
            'top_selling_employee' => serialize($top_selling_employee)
        ];

        // Redirect to view_report.php with serialized data
        $query = http_build_query($data);
        header("Location: viewReport.php?$query");
        exit();
    } else {
        // Handle validation errors by setting error messages to be displayed on report.php page
        $errMsg = $dateErr;
        header("Location: managerReport.php?errMsg=" . urlencode($errMsg));
        exit();
    }
}
?>
