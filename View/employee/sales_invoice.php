<?php
session_start();
include("../../Model/dbconnect.php");

if (!isset($_SESSION['customer']) || !isset($_SESSION['basket'])) {
    die("No customer or basket data found.");
}

$customer = $_SESSION['customer'];
$basket = $_SESSION['basket'];

// Fetch customer details
$customerDetails = [
    'Name' => $customer['f_name'] . ' ' . $customer['l_name'],
    'Address' => $customer['address'],
    'Post Code' => $customer['post_code'],
    'Town' => $customer['town'],
];

// Calculate basket totals
$totalPrice = 0;
$productDetails = [];

foreach ($basket as $item) {
    $stmt = $conn->prepare("SELECT name, price FROM Product WHERE ID = ?");
    $stmt->bind_param("i", $item['product_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $subTotal = $product['price'] * $item['quantity'];
        $totalPrice += $subTotal;

        $productDetails[] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $item['quantity'],
            'subTotal' => $subTotal,
        ];
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            max-width: 800px;
            margin: auto;
        }
        h1, h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .totals {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Invoice</h1>
    <h2>Customer Details</h2>
    <p>
        <strong>Name:</strong> <?php echo $customerDetails['Name']; ?><br>
        <strong>Address:</strong> <?php echo $customerDetails['Address']; ?><br>
        <strong>Post Code:</strong> <?php echo $customerDetails['Post Code']; ?><br>
        <strong>Town:</strong> <?php echo $customerDetails['Town']; ?><br>
    </p>

    <h2>Products</h2>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productDetails as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo number_format($product['subTotal'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Total</h2>
    <p class="totals">Total Price: $<?php echo number_format($totalPrice, 2); ?></p>
</body>
</html>
