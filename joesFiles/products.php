<?php
try {
    $db = new PDO('sqlite:' . __DIR__ . '/../../Model/Terra_Core_DB.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

//Switch case for each CRUD operation + Details Window + Sort
if (!empty($data) && isset($data['action'])) {
    $action = $data['action'];
    try {
        switch ($action) {
            
                case 'create':
                    try {
                        $db->beginTransaction();
    
                        $stmt = $db->prepare("INSERT INTO Product (name, description, price, weight, size, CPU, GPU, RAM, hard_drive)
                                              VALUES (:name, :description, :price, :weight, :size, :CPU, :GPU, :RAM, :hard_drive)");
                        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
                        $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
                        $stmt->bindValue(':price', $data['price'], PDO::PARAM_STR);
                        $stmt->bindValue(':weight', $data['weight'], PDO::PARAM_STR);
                        $stmt->bindValue(':size', $data['size'], PDO::PARAM_STR);
                        $stmt->bindValue(':CPU', $data['CPU'], PDO::PARAM_STR);
                        $stmt->bindValue(':GPU', $data['GPU'], PDO::PARAM_STR);
                        $stmt->bindValue(':RAM', $data['RAM'], PDO::PARAM_STR);
                        $stmt->bindValue(':hard_drive', $data['hard_drive'], PDO::PARAM_STR);
                        $stmt->execute();
    
                        $productID = $db->lastInsertId();
    
                        $stmt = $db->prepare("INSERT INTO stock (product, quantity, branch) 
                                              VALUES (:productID, :quantity, :branch)");
                        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
                        $stmt->bindValue(':quantity', $data['stock'], PDO::PARAM_INT);
                        $stmt->bindValue(':branch', $data['branch'], PDO::PARAM_INT);
                        $stmt->execute();
    
                        $db->commit();
                        echo json_encode(['success' => true]);
                    } catch (Exception $e) {
                        $db->rollBack();
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
                            $stmt->bindValue(':productID', $data['productID'], PDO::PARAM_INT);
                            $stmt->execute();
                            $product = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                            if ($product) {
                                $product['lowStockClass'] = ($product['quantity'] < 10) ? 'low-stock' : '';
                                echo json_encode($product);
                            } else {
                                echo json_encode(['error' => 'Product not found']);
                            }
                        } else {
                            $stmt = $db->prepare("SELECT Product.ID, Product.name, Product.description, Product.price, 
                                                  Product.weight, Product.size, Product.CPU, Product.GPU, 
                                                  Product.RAM, Product.hard_drive, stock.quantity
                                                  FROM Product
                                                  LEFT JOIN stock ON Product.ID = stock.product");
                            $stmt->execute();
                            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                            if ($products) {

                                foreach ($products as &$product) {
                                    $product['lowStockClass'] = ($product['quantity'] < 10) ? 'low-stock' : '';
                                }
                                echo json_encode($products);
                            } else {
                                echo json_encode(['error' => 'No products found']);
                            }
                        }
                        break;
    
                case 'update':
                    try {
                        $db->beginTransaction();
    
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
                        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
                        $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
                        $stmt->bindValue(':price', $data['price'], PDO::PARAM_STR);
                        $stmt->bindValue(':weight', $data['weight'], PDO::PARAM_STR);
                        $stmt->bindValue(':size', $data['size'], PDO::PARAM_STR);
                        $stmt->bindValue(':CPU', $data['CPU'], PDO::PARAM_STR);
                        $stmt->bindValue(':GPU', $data['GPU'], PDO::PARAM_STR);
                        $stmt->bindValue(':RAM', $data['RAM'], PDO::PARAM_STR);
                        $stmt->bindValue(':hard_drive', $data['hard_drive'], PDO::PARAM_STR);
                        $stmt->bindValue(':productID', $data['productID'], PDO::PARAM_INT);
                        
                        if (!$stmt->execute()) {
                            $errorInfo = $stmt->errorInfo();
                            echo json_encode(['success' => false, 'error' => $errorInfo]);
                            exit();
                        }
    
                        $stmt = $db->prepare("UPDATE stock SET quantity = :quantity WHERE product = :productID");
                        $stmt->bindValue(':quantity', $data['quantity'], PDO::PARAM_INT);
                        $stmt->bindValue(':productID', $data['productID'], PDO::PARAM_INT);
                        if (!$stmt->execute()) {
                            $errorInfo = $stmt->errorInfo();
                            echo json_encode(['success' => false, 'error' => $errorInfo]);
                            exit();
                        }
                        
                        $db->commit();
                        echo json_encode(['success' => true]);
                    } catch (Exception $e) {
                        $db->rollBack();
                        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                    }
                    break;
    
                case 'delete':
                    $stmt = $db->prepare("DELETE FROM Product WHERE ID = :productID");
                    $stmt->bindValue(':productID', $data['productID'], PDO::PARAM_INT);
                    $stmt->execute();
                    echo json_encode(['success' => true]);
                    break;
    
                case 'sort':
                    $orderBy = '';
                    switch ($data['sortOption']) {
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
                    $stmt = $db->prepare("SELECT product.ID, product.name, product.description, product.price, 
                                 product.weight, product.size, product.CPU, product.GPU, 
                                 product.RAM, product.hard_drive, stock.quantity
                          FROM product
                          LEFT JOIN stock ON product.ID = stock.product
                          ORDER BY $orderBy");
                    $stmt->execute();
                    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    try {
        $stmt = $db->query("SELECT * FROM Product LEFT JOIN stock ON Product.ID = stock.product");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $products = [];
    }
    include("productsView.php");
}
?>