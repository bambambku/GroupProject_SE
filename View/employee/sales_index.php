<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// if ($_SESSION["salesCorrect"] == true) {
//     $_SESSION["basket"] = [];
//     $_SESSION["salesCorrect"] = false;
// }

// logout and redirect to login if user is not logged in or not an employee 
if ($_SESSION["user_role"] != 1) {
    if ($_SESSION["user_role"]["name"] != 'Employee') {
    header("Location: ../login/login.php");
}}


include("../../includes/dbconnect.php");
include("sales_basket.php");
include("../../includes/header2.php");


?>

<title>Employee</title>
<link rel="stylesheet" href="../../CSS/employee.css">
<meta name="description" content="Terra Corre - Sales Index">
<style>
    .sidebar {
        display: none;
    }
    </style>
</header>
<body class="employee-background">

<?php
include("../../includes/navbar.php");

// Handle basket actions
if (isset($_GET['add'])) {
    addToBasket($_GET['add']);
} elseif (isset($_GET['remove'])) {
    removeFromBasket($_GET['remove']);
} elseif (isset($_GET['clear'])) {
    $_SESSION['basket'] = [];
}

if(!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = [];
}

$basket = $_SESSION['basket'];
$_SESSION['branch_id'] = 1; // wait for Charlie to fix it in login
$currentBranch = $_SESSION['branch_id']; // wait for Charlie to fixc it in login

$searchTerm = "";
if (isset($_POST['search'])) {
    $searchTerm = "%" . $_POST['search'] . "%";
}

// Prepare the query
$sql = "SELECT product.ID, product.name, stock.quantity, product.price 
        FROM stock
        INNER JOIN product ON stock.product = product.ID
        AND stock.branch = :branch
        WHERE stock.quantity > 0";

$params = ['branch' => $currentBranch];

if ($searchTerm) {
    $sql .= " AND product.name LIKE :searchTerm";
    $params['searchTerm'] = $searchTerm;
}

// Execute the query using PDO
$stmt = $myPDO->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($products);

?>
<main class="main-container">
<div class="sales-tables">
    <div class="sales-tables-stock">
        <div class="sales-title">
            <h2>Stock</h2>
            <div class="form">
                <form action="" method="post">
                    <!-- <label for="search">Search</label><br> -->
                    <input type="text" id="search" name="search" value="<?php echo htmlspecialchars(isset($_POST['search']) ? $_POST['search'] : ''); ?>">
                    <input type="submit" value="Search" name="salesSearch">
                    <a href="sales_index.php">Clear</a>
                </form>
            </div>
        </div>
        <table>
            <tr>
                <th>Product Name</th>
                <th>On Stock</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($product['price']); ?></td>
                    <td>
                        <a href="sales_index.php?add=<?php echo htmlspecialchars($product['ID']); ?>">Add</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="sales-tables-basket">
        <div class="sales-title">
            <h2>Basket</h2>
            <a href="sales_index.php?clear"><button type="button">Clear</button></a>
        </div>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($basket as $product) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($product['price']); ?></td>
                    <td>
                        <a href="sales_index.php?remove=<?php echo htmlspecialchars($product['ID']); ?>">Remove</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <h3>Total: <?php echo htmlspecialchars(array_sum(array_column($basket, 'price'))); ?></h3>
        <button type="button" onclick="openModal('finaliseSaleModal')" <?php if($_SESSION['basket'] == []) echo 'disabled'?>>Finalise Sale</button>
    </div>
</div>

<div id="finaliseSaleModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal('finaliseSaleModal')">&times;</span>
        <h2>Finalise Sale</h2>
        <p>Are you sure you want to finalise this sale?</p>
        <div>
            <a href="sales_chooseCustomer.php"><button>Confirm</button></a>
            <button type="button" onclick="closeModal('finaliseSaleModal')">Cancel</button>
        </div>
    </div>
</div>
</main>
<?php
include("modalStyleAndScript.php");
include("../../includes/footer.php");
?>
