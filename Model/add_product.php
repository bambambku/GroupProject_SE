<?php
include("dbconnect.php");

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['name'], $data['description'], $data['price'], $data['weight'], $data['size'], $data['CPU'], $data['GPU'], $data['RAM'], $data['hard_drive'])) {
    $name = $data['name'];
    $description = $data['description'];
    $price = $data['price'];
    $weight = $data['weight'];
    $size = $data['size'];
    $CPU = $data['CPU'];
    $GPU = $data['GPU'];
    $RAM = $data['RAM'];
    $hard_drive = $data['hard_drive'];
    
    $sql = "INSERT INTO Product (name, description, price, weight, size, CPU, GPU, RAM, hard_drive)
            VALUES ('$name', '$description', '$price', '$weight', '$size', '$CPU', '$GPU', '$RAM', '$hard_drive')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
}
