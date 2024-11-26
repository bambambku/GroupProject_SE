<?php
include ("../../Model/sqliteconnect.php");

$stmt = $db->query("SELECT product.ID, product.name, product.price, stock.quantity 
                    FROM product
                    LEFT JOIN stock ON product.ID = stock.product");

$products = [];
while ($row = $stmt->fetchArray(SQLITE3_ASSOC)) {
    $products[] = $row;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data) && isset($data['action'])) {
    $action = $data['action'];
    //Switch case for each CRUD operation + Details Window + Sort
    try {
        switch ($action) {
            case 'details':
                $stmt = $db->prepare("SELECT product.ID, product.name, product.description, product.price, 
                                     product.weight, product.size, product.CPU, product.GPU, product.RAM, product.hard_drive
                                      FROM product WHERE product.ID = :productID");
                $stmt->bindValue(':productID', $data['productID'], SQLITE3_INTEGER);
                $result = $stmt->execute();
                $product = $result->fetchArray(SQLITE3_ASSOC);
                echo json_encode($product);
                break;

                case 'create':
                    try {
                        $db->exec("BEGIN TRANSACTION");
                        
                        $stmt = $db->prepare("INSERT INTO Product (name, description, price, weight, size, CPU, GPU, RAM, hard_drive)
                                                VALUES (:name, :description, :price, :weight, :size, :CPU, :GPU, :RAM, :hard_drive)");
                        $stmt->bindValue(':name', $data['name'], SQLITE3_TEXT);
                        $stmt->bindValue(':description', $data['description'], SQLITE3_TEXT);
                        $stmt->bindValue(':price', $data['price'], SQLITE3_TEXT);
                        $stmt->bindValue(':weight', $data['weight'], SQLITE3_TEXT);
                        $stmt->bindValue(':size', $data['size'], SQLITE3_TEXT);
                        $stmt->bindValue(':CPU', $data['CPU'], SQLITE3_TEXT);
                        $stmt->bindValue(':GPU', $data['GPU'], SQLITE3_TEXT);
                        $stmt->bindValue(':RAM', $data['RAM'], SQLITE3_TEXT);
                        $stmt->bindValue(':hard_drive', $data['hard_drive'], SQLITE3_TEXT);
                        $stmt->execute();
                
                        $productID = $db->lastInsertRowID();
                
                        $stmt = $db->prepare("INSERT INTO stock (product, quantity, branch) VALUES (:productID, :quantity, :branch)");
                        $stmt->bindValue(':productID', $productID, SQLITE3_INTEGER);
                        $stmt->bindValue(':quantity', $data['stock'], SQLITE3_INTEGER);
                        $stmt->bindValue(':branch', $data['branch'], SQLITE3_INTEGER);
                        $stmt->execute();
                        $db->exec("COMMIT");
                
                        echo json_encode(['success' => true]);
                    } catch (Exception $e) {
                        $db->exec("ROLLBACK");
                        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                    }
                    break;
                
                    case 'read':
                        if (isset($data['productID'])) {
                            $stmt = $db->prepare("SELECT Product.ID, Product.name, Product.description, Product.price, 
                                                         Product.weight, Product.size, Product.CPU, Product.GPU, 
                                                         Product.RAM, Product.hard_drive, stock.quantity
                                                        FROM Product
                                                        LEFT JOIN stock ON Product.ID = stock.product
                                                        WHERE Product.ID = :productID");
                            $stmt->bindValue(':productID', $data['productID'], SQLITE3_INTEGER);
                            $result = $stmt->execute();
                            $product = $result->fetchArray(SQLITE3_ASSOC);
                            echo json_encode($product);
                        }
                        break;

                    case 'update':
                        try {
                            $db->exec("BEGIN TRANSACTION");
                    
                            $stmt = $db->prepare("UPDATE Product SET 
                                name = :name, 
                                description = :description, 
                                price = :price, 
                                weight = :weight, 
                                size = :size, 
                                CPU = :CPU, 
                                GPU = :GPU, 
                                RAM = :RAM, 
                                hard_drive = :hard_drive 
                                WHERE ID = :productID");
                    
                            $stmt->bindValue(':name', $data['name'], SQLITE3_TEXT);
                            $stmt->bindValue(':description', $data['description'], SQLITE3_TEXT);
                            $stmt->bindValue(':price', $data['price'], SQLITE3_TEXT);
                            $stmt->bindValue(':weight', $data['weight'], SQLITE3_TEXT);
                            $stmt->bindValue(':size', $data['size'], SQLITE3_TEXT);
                            $stmt->bindValue(':CPU', $data['CPU'], SQLITE3_TEXT);
                            $stmt->bindValue(':GPU', $data['GPU'], SQLITE3_TEXT);
                            $stmt->bindValue(':RAM', $data['RAM'], SQLITE3_TEXT);
                            $stmt->bindValue(':hard_drive', $data['hard_drive'], SQLITE3_TEXT);
                            $stmt->bindValue(':productID', $data['productID'], SQLITE3_INTEGER);
                            
                            $stmt->execute();
                            
                            $stmt = $db->prepare("UPDATE Stock SET quantity = :quantity WHERE product = :productID");
                            $stmt->bindValue(':quantity', $data['stock'], SQLITE3_INTEGER);
                            $stmt->bindValue(':productID', $data['productID'], SQLITE3_INTEGER);
                    
                            $stmt->execute();
                    
                            $db->exec("COMMIT");
                            echo json_encode(['success' => true]);
                        } catch (Exception $e) {
                            $db->exec("ROLLBACK");
                            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                        }
                        break;

            case 'delete':
                $stmt = $db->prepare("DELETE FROM Product WHERE ID = :productID");
                $stmt->bindValue(':productID', $data['productID'], SQLITE3_INTEGER);
                $stmt->execute();
                echo json_encode(['success' => true]);
                break;

            case 'sort':
                $sortOption = $data['sortOption'];
                $orderBy = '';
                switch ($sortOption) {
                    case 'lowStock':
                        $orderBy = 'stock.quantity ASC';
                        break;
                    case 'priceAsc':
                        $orderBy = 'product.price ASC';
                        break;
                    case 'priceDesc':
                        $orderBy = 'product.price DESC';
                        break;
                    default:
                        $orderBy = 'product.name ASC';
                        break;
                }
                $stmt = $db->prepare("SELECT product.ID, product.name, product.price, stock.quantity
                FROM product
                LEFT JOIN stock ON product.ID = stock.product
                ORDER BY $orderBy");

                $products = [];
                $result = $stmt->execute();
                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $products[] = $row;
                }
                echo json_encode($products);
                break;              

            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
                break;
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    include("product_view.php");
}
?>