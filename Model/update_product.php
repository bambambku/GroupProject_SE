<?php
include("dbconnect.php");
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['productID'])){
    $productId = $data['productID'];
    $name = $data['name'];
    $description = $data['description'];
    $price = $data['price'];
    $weight = $data['weight'];
    $size = $data['size'];
    $CPU = $data['CPU'];
    $GPU = $data['GPU'];
    $RAM = $data['RAM'];
    $hard_drive = $data['hard_drive'];
    
    $sql = "UPDATE Product SET name='$name', description='$description', price='$price', weight='$weight', 
            size='$size', CPU='$CPU', GPU='$GPU', RAM='$RAM', hard_drive='$hard_drive' WHERE ID=$productId";

    if ($conn->query($sql) === TRUE){
        echo json_encode(['success' => true]);
    }
    else{
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }}
else{
    echo json_encode(['success' => false, 'message' => 'No product ID provided']);
}
?>