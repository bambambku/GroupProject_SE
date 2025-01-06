<?php
// include("../../Model/dbconnect.php");
include("../../includes/dbconnect.php");
global $myPDO;
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = [];
}

$basket = $_SESSION['basket'];

function addToBasket($productID) {
    global $basket, $myPDO;
    
    // global $conn;
    $currentBranch = 1;
    $sql = "SELECT product.ID, product.name, stock.quantity, product.price 
            FROM product, stock 
            WHERE stock.branch = :branch AND stock.product = product.ID AND product.ID = :productID";
    
    $stmt = $myPDO->prepare($sql);
    $stmt->execute([
        'branch' => $currentBranch,
        'productID' => $productID
    ]);

    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        return;
    }
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