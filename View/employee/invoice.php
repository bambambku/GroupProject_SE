<?php
session_start();
include("../../includes/dbconnect.php");
include("sales_basket.php");
include("../../includes/header2.php");

if (!isset($_SESSION['basket']) || !isset($_SESSION['customer'])) {
    header("Location: sales_index.php");
    exit;
}

$customer = $_SESSION['customer'];
$basket = $_SESSION['basket'];
$total = 0;

?>
<style>
    @media print {
        .dont-print {
            display: none;
        }
    }
</style>

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
                    <strong>Name:</strong> <?php echo htmlspecialchars($customer['f_name'] . ' ' . $customer['l_name']); ?><br>
                    <strong>Address:</strong> <?php echo htmlspecialchars($customer['address']); ?><br>
                    <strong>Post Code:</strong> <?php echo htmlspecialchars($customer['post_code']); ?><br>
                    <strong>Town:</strong> <?php echo htmlspecialchars($customer['town']); ?><br>
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
                <div>
                    <h3>Total: <?php echo number_format($total, 2); ?></h3>
                </div>
            </div>
        <div class="invoice-buttons">
            <a href="sales_index.php"><button class="dont-print" type="button">Start New Sale</button></a>
            <button class="dont-print" type="button" onclick="printInvoice()">Print Invoice</button>
        </div>
    </div>
</main>

<?php include("../../includes/footer.php"); ?>

<script>
    footer = document.querySelector("footer");
    footer.classList.add("dont-print");
    function printInvoice() {
        window.print();
    }
</script>

</body>
