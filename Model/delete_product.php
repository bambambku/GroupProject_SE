<?php
include("dbconnect.php");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['productID'])){
    $productId = $data['productID'];
    
    $sql = "DELETE FROM PRODUCT WHERE ID = $productId";

    if ($conn->query($sql) === TRUE){
        echo json_encode(['success' => true]);
    }
    else{
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
}
