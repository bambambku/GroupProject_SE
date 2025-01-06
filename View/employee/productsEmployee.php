<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// logout and redirect to login if user is not logged as an employee 
if ($_SESSION["user_role"] != 1) {
    if ($_SESSION["user_role"]["name"] != 'Employee') {
    header("Location: ../login/login.php");
}}

include ("../../query.php");
if(!isset($_SESSION['branch_id'])) {
    $_SESSION['branch_id'] = 1;
}
$currentBranch = $_SESSION['branch_id'];

$searchTerm = "";
if (isset($_POST['search'])) {
    $searchTerm = "%" . $_POST['search'] . "%";
}


$sql = "SELECT * FROM Product LEFT JOIN stock ON Product.ID = stock.product WHERE stock.branch = :branch";
$params = ['branch' => $currentBranch];

if ($searchTerm) {
    $sql .= " AND product.name LIKE :searchTerm";
    $params['searchTerm'] = $searchTerm;
}

$stmt = $myPDO->prepare($sql);
$stmt->execute($params);

include("../../includes/header2.php");
?>
    <title>Branch Stock</title>
    <link rel="stylesheet" href="../../CSS/employee.css" media="screen and (min-width: 1025px)">
</head>
<body class="employee-background">
<?php include '../../includes/navbar.php'; ?>
<main class="main-container">
<div class="general-content-out">
    <!-- <div class="general-content-bttn-area">
    </div>
    <div class="general-content-in">     
        </div> -->
    <h1>Products:</h1>
    <form action="" method="post">
        <input type="text" id="search" name="search" value="<?php echo htmlspecialchars(isset($_POST['search']) ? $_POST['search'] : ''); ?>">
        <input type="submit" value="Search" name="salesSearch">
        <a href="productsEmployee.php">Clear</a>
    </form>
    <p id="click-headers"><i><strong> * </strong>Click on the table headers to sort the table</i></p>
    <table id="laptopTable">
    <thead>
        <tr>
            <th onclick="sortTable(0)">Name</th>
            <th onclick="sortTable(1)">Description</th>
            <th onclick="sortTable(2)">Price (£)</th>
            <th onclick="sortTable(3)">Weight</th>
            <th onclick="sortTable(4)">Size</th>
            <th onclick="sortTable(5)">CPU</th>
            <th onclick="sortTable(6)">GPU</th>
            <th onclick="sortTable(7)">RAM</th>
            <th onclick="sortTable(8)">Hard Drive</th>
            <th onclick="sortTable(9)">Stock</th>
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
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
</div>
    <!-- </div>            
</div> -->
</main>
<?php
include '../../includes/footer.php';
?>
</body>
<script>
    let sortDirection = {}; 

    function sortTable(columnIndex) {
        let table = document.getElementById("laptopTable");
        let tbody = table.getElementsByTagName("tbody")[0];
        let rows = Array.from(tbody.rows);

        sortDirection[columnIndex] = !sortDirection[columnIndex];

        rows.sort((rowA, rowB) => {
            let cellA = rowA.cells[columnIndex].innerText.trim();
            let cellB = rowB.cells[columnIndex].innerText.trim();

            let numA = parseFloat(cellA);
            let numB = parseFloat(cellB);
            
            if (!isNaN(numA) && !isNaN(numB)) {
                return sortDirection[columnIndex] ? numA - numB : numB - numA;
            } else {
                return sortDirection[columnIndex] ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
            }
        });

        tbody.innerHTML = "";
        rows.forEach(row => tbody.appendChild(row));
    }
</script>
</html>

