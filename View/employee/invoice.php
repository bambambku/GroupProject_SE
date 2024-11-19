<?php
include("../../Model/query.php");
include("../../Model/dbconnect.php");
include("sales_basket.php");
include("../../includes/header.php");

if (!isset($_SESSION['basket'])) {
    header("Location: sales_index.php");
}

$customer = $_SESSION['customer'];
$basket = $_SESSION['basket'];
$currentBranch = 1;

?>

</header>
<body id="employee-background">
    <main class="main-container">
        <div class="invoice">
            <div class="invoice-header">
                <h1>Invoice</h1><br>
            </div>
            <div class="invoice-sender">
                <h2>Sender Details</h2>
                <p>Company Name: The Company</p>
                <p>Address: 123 Fake Street</p>
                <p>Post Code: AB1 2CD</p>
                <p>Town: Faketown</p>
            <br>
            </div>
            <div class="invoice-customer">
                <h2>Customer Details</h2>
                <p>
                    <strong>Name:</strong><?php echo $customer['f_name'] . ' ' . $customer['l_name']; ?><br>
                    <strong>Address:</strong> <?php echo $customer['address']; ?><br>
                    <strong>Post Code:</strong> <?php echo $customer['post_code']; ?><br>
                    <strong>Town:</strong> <?php echo $customer['town']; ?><br>
                </p>
            <br>
            </div>
            <div class="invoice-table">
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($basket as $product) { ?>
                            <tr>
                                <td><?php echo $product['name']?></td>
                                <td><?php echo $product['quantity']?></td>
                                <td><?php echo $product['price']?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div>
                    <h3>Total: <?php echo array_sum(array_column($basket, 'price')) ?></h3>
                </div>
            </div>
        <div class="invoice-buttons">
            <a href="sales_index.php"><button type="button">Start New Sale</button></a>
            <button type="button" onclick="printInvoice()">Print Invoice</button>
        </div>
    </div>
</main>

<?php include("../../includes/footer.php"); ?>

</body>
