<?php
include("../../../Model/dbconnect.php");

session_start();

if (!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = [];
}

$basket = $_SESSION['basket'];

function addToBasket($productID) {
    global $basket;
    
    global $conn;
    $currentBranch = 1;
    $sql = "SELECT product.ID, product.name, stock.quantity, product.price FROM product, stock WHERE stock.branch= ? AND stock.product=product.ID AND product.ID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $currentBranch, $productID);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
    $maxQty = $product['quantity'];
    if(isset($basket[$productID])) {
        if($basket[$productID]['quantity'] >= $maxQty) {
            return;
        }
        $basket[$productID]['quantity'] ++;
    } else {
        $basket[$productID] = $product;
        $basket[$productID]['quantity'] = 1;
    }
    $_SESSION['basket'] = $basket;    
}

function removeFromBasket($productId) {
    global $basket;
    if (isset($basket[$productId])) {
        $basket[$productId]['quantity']--;
        if ($basket[$productId]['quantity'] <= 0) {
            unset($basket[$productId]);
        }
    }
    $_SESSION['basket'] = $basket;
}

?>