<?php
session_start();
include("../../includes/dbconnect.php");
include("sales_basket.php");
include("../../includes/header2.php");

$isGuest = isset($_GET['guest']) && $_GET['guest'] == 1;

if (!$isGuest && (!isset($_SESSION['basket']) || !isset($_SESSION['customer']))) {
    header("Location: sales_index.php");
    exit;
}

$customer = $isGuest ? null : $_SESSION['customer'];
$basket = $_SESSION['basket'];
$total = 0;

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

<?php include("../../includes/footer.php"); ?>

<script>
    footer = document.querySelector("footer");
    footer.classList.add("dont-print");
    function printInvoice() {
        window.print();
    }
</script>

</body>
