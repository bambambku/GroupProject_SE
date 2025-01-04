<?php
include("dbconnect.php");

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['productID'])){
    $productId = $data['productID'];
    $sql = "SELECT * FROM Product WHERE ID = $productId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        echo json_encode($result->fetch_assoc());
    }
    else{
        echo json_encode(['success' => false, 'message' => 'Product not found']);
    }
}
else{
    echo json_encode(['success' => false, 'message' => 'No product ID provided']);
}
?>