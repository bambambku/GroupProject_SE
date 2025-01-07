<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$saleCorrect = false;
// logout and redirect to login if user is not logged in or not an employee 
if ($_SESSION["user_role"] != 1) {
    if ($_SESSION["user_role"]["name"] != 'Employee') {
    header("Location: ../login/login.php");
}}

include("../../includes/dbconnect.php");
include("sales_basket.php");
include("../../includes/header2.php");

// for time being, assume user is logged in
// $_SESSION['user_id'] = 1;
// for time being assume branch is 1
$currentBranch = $_SESSION['branch_id'];

$isGuest = isset($_GET['guest']) && $_GET['guest'] == 1;

if (!$isGuest && (!isset($_SESSION['basket']) || !isset($_SESSION['customer']))) {
    header("Location: sales_index.php");
    exit;
}

$customer = $isGuest ? null : $_SESSION['customer'];
$basket = $_SESSION['basket'];
$total = 0;
$userId = $_SESSION['user_id'];
$newSaleId = 1;

try {
    // Retrieve the highest Sale ID
    $stmt = $myPDO->query("SELECT MAX(ID) AS max_id FROM Sale");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $newSaleId = $row ? $row['max_id'] + 1 : 1;
    $saleCustomer = $isGuest ? 0 : $customer['ID'];

    // Insert each item in the basket into the Sale table
    foreach ($basket as $productId => $productDetails) {
        $quantity = $productDetails['quantity'];

        $stmt = $myPDO->prepare("
            INSERT INTO Sale (ID, product, customer, user, time_date, quantity)
            VALUES (:id, :product, :customer, :user, :time_date, :quantity)
        ");
        $stmt->execute([
            ':id' => $newSaleId,
            ':product' => $productId,
            ':customer' => $saleCustomer,
            ':user' => $userId,
            ':time_date' => date('Y-m-d H:i:s'),
            ':quantity' => $quantity
        ]);

        // Adjust stock for the product
        $stmt = $myPDO->prepare("SELECT quantity FROM Stock WHERE product = :product AND branch = :branch");
        $stmt->execute([':product' => $productId, ':branch' => $currentBranch]);
        $stock = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stock) {
            $currentStock = $stock['quantity'];

            if ($currentStock >= $quantity) {
                $stmt = $myPDO->prepare("
                    UPDATE Stock
                    SET quantity = quantity - :quantity
                    WHERE product = :product
                    AND branch = :branch
                ");
                $stmt->execute([
                    ':quantity' => $quantity,
                    ':product' => $productId,
                    ':branch' => $currentBranch
                ]);
            } else {
                echo "<p>Insufficient stock for product ID $productId. Skipping this item.</p>";
            }
        } else {
            echo "<p>Product ID $productId not found in stock.</p>";
        }
    }

    echo "<p class='dont-print'>Sale recorded and stock adjusted successfully!</p>";
    $saleCorrect = true;

} catch (Exception $e) {
    echo "<p class='dont-print'>Something went wrong while recording the sale: " . $e->getMessage() . "</p>";
}
?>

<style>
    @media print {
        .dont-print {
            display: none;
        }
    }

    .invoice-sender, .invoice-customer {
    width: 45%;
    display: inline-block;
    vertical-align: top;
    }

    .invoice {
        padding-top: 10vh; 
    }

</style>

</header>
<body id="employee-background">
    <main class="main-container">
        <div class="invoice">
            <div class="invoice-header">
                <h1>Invoice</h1><br>
                <p>
                    <strong>Sale ID:</strong> <i>#<?php echo $newSaleId; ?></i><br>
                    <strong>Date:</strong> <i><?php echo date('d-m-Y H:i'); ?></i><br>
                    <strong>Branch:</strong> <i><?php echo $currentBranch; ?></i>
                </p>
            </div>
            <div class="invoice-sender">
                <h2>Sender Details</h2>
                <p>
                    <strong>Company Name:</strong> The Company<br>
                    <strong>Address:</strong> 123 Fake Street<br>
                    <strong>Post Code:</strong> AB1 2CD<br>
                    <strong>Town:</strong> Faketown<br>
                </p>
            <br>
            </div>
            <div class="invoice-customer">
            
                <?php if ($isGuest): ?>
                    <h2>Buy as a Guest purchase</h2>
                <?php else: ?>
                    <h2>Customer Details</h2>
                    <p>
                        <strong>Name:</strong> <?php echo htmlspecialchars($customer['f_name'] . ' ' . $customer['l_name']); ?><br>
                        <strong>Address:</strong> <?php echo htmlspecialchars($customer['address']); ?><br>
                        <strong>Post Code:</strong> <?php echo htmlspecialchars($customer['post_code']); ?><br>
                        <strong>Town:</strong> <?php echo htmlspecialchars($customer['town']); ?><br>
                    </p>
                <?php endif; ?>
            <br>
            </div>
            <div class="invoice-table" style="width: 70%;">
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($basket as $product) { 
                            $productName = htmlspecialchars($product['name']);
                            $quantity = htmlspecialchars($product['quantity']);
                            $price = htmlspecialchars($product['price']);
                            $total += $quantity * $price;
                        ?>
                            <tr>
                                <td><?php echo $productName; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo number_format($price, 2); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="invoice-total" style="text-align: right; position: relative; right: 19.8%;">
                    <h3>Total: <?php echo number_format($total, 2); ?></h3>
                </div>
            </div>
        <div class="invoice-buttons">
            <a href="sales_index.php"><button class="dont-print" type="button">Start New Sale</button></a>
            <button class="dont-print" type="button" onclick="printInvoice()">Print Invoice</button>
        </div>
    </div>
</main>

<?php include("../../includes/footer.php"); 
    // if ($saleCorrect) $_SESSION['saleCorrect'] = true;
    if ($saleCorrect) $_SESSION['basket'] = [];
?>

<script>
    footer = document.querySelector("footer");
    footer.classList.add("dont-print");
    function printInvoice() {
        window.print();
    }
</script>

</body>
