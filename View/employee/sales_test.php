<?php
// echo $undefined_variable;

// include("../../Model/query.php");
// include("../../Model/dbconnect.php");
// include("sales_basket.php");
include("../../includes/header.php");
include("../../includes/dbconnect.php");

$sql = "SELECT * FROM product LIMIT 1";
$stmt = $myPDO->prepare($sql);
$stmt->execute();
$testData = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
var_dump($testData);
echo "</pre>";

?>

<link rel="stylesheet" href="../../CSS/employee.css" media="screen and (min-width: 1025px)">
</header>
<body id="employee-background">

<?php
include("../../includes/navbar.php");