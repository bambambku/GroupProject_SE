<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../CSS/style-products-desktop.css" media="screen and (min-width: 1025px)">
    <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)">
    <link rel="stylesheet" href="../../CSS/stock-manager.css" media="screen and (min-width: 1025px)">
    <title>Product View</title>
</head>
<body>
<?php include '../../includes/navbar.php'; ?>
<main class="main-container">
    <h1>Products:</h1>
    <div class="general-content-out">
        <div class="general-content-bttn-area">
            <button id="modalButtonProducts">Create New</button>
                <select id="sortSelect">
                <option value="lowStock">Low Stock</option>
                <option value="priceAsc">Price Ascending</option>
                <option value="priceDesc">Price Descending</option>
                </select>
            <button id="sortButton">Sort By</button>
        </div>
        <div class="general-content-in">
            <div id="modalWindowProducts" class="modal">
                <form>
                    <label for="Name">Product name:</label><br>
                    <input type="text" id="productName" name="productName"><br>
                    <label for="Description">Description:</label><br>
                    <input type="text" id="productDescription" name="productDescription"><br>
                    <label for="Price">Price:</label><br>
                    <input type="text" id="productPrice" name="productPrice"><br>
                    <label for="Weight">Weight:</label><br>
                    <input type="text" id="productWeight" name="productWeight"><br>
                    <label for="Size">Size:</label><br>
                    <input type="text" id="productSize" name="productSize"><br>
                    <label for="CPU">CPU:</label><br>
                    <input type="text" id="productCPU" name="productCPU"><br>
                    <label for="GPU">GPU:</label><br>
                    <input type="text" id="productGPU" name="productGPU"><br>
                    <label for="RAM">RAM:</label><br>
                    <input type="text" id="productRAM" name="productRAM"><br>
                    <label for="Hard-Drive">Hard-Drive:</label><br>
                    <input type="text" id="productHard-Drive" name="productHard-Drive"><br>
                    <label for="productStock">Quantity:</label><br>
                    <input type="number" id="productStock" name="productStock"><br>
                    <label for="productBranch">Branch:</label><br>
                    <input type="number" id="productBranch" name="productBranch"><br>
                    <button type="button" id="closeButton">Close</button>
                    <button type="button" id="addButton">Add</button>
                </form>       
            </div>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
                
                <?php foreach ($products as $product): ?>
                <tr>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['price']); ?></td>
                <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                    <td>
                        <button id="editButton<?php echo $product['ID']; ?>" class="edit-button" data-id="<?php echo $product['ID']; ?>">Edit</button>
                        <button id="detailsButton<?php echo $product['ID']; ?>" class="details-button" data-id="<?php echo $product['ID']; ?>">Details</button>
                        <button id="deleteButton<?php echo $product['ID']; ?>" class="delete-button" data-id="<?php echo $product['ID']; ?>">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            
        </div>
        </div>            
    </div>
    <div id="modalWindowProductsEdit" class="modal" style="display: none;">
        <form>
            <input type="hidden" id="editProductId">
            <label for="editProductName">Product name:</label><br>
            <input type="text" id="editProductName" name="editProductName"><br>
            <label for="editProductDescription">Description:</label><br>
            <input type="text" id="editProductDescription" name="editProductDescription"><br>
            <label for="editProductPrice">Price:</label><br>
            <input type="text" id="editProductPrice" name="editProductPrice"><br>
            <label for="editProductWeight">Weight:</label><br>
            <input type="text" id="editProductWeight" name="editProductWeight"><br>
            <label for="editProductSize">Size:</label><br>
            <input type="text" id="editProductSize" name="editProductSize"><br>
            <label for="editProductCPU">CPU:</label><br>
            <input type="text" id="editProductCPU" name="editProductCPU"><br>
            <label for="editProductGPU">GPU:</label><br>
            <input type="text" id="editProductGPU" name="editProductGPU"><br>
            <label for="editProductRAM">RAM:</label><br>
            <input type="text" id="editProductRAM" name="editProductRAM"><br>
            <label for="editProductHardDrive">Hard Drive:</label><br>
            <input type="text" id="editProductHardDrive" name="editProductHardDrive"><br>
            <label for="editProductStock">Quantity:</label><br>
            <input type="number" id="editProductStock" name="editProductStock"><br>
            <button type="button" id="closeButtonEdit">Close</button>
            <button type="button" id="saveEditButton">Save</button>
        </form>
    </div>
    <script src="../../js/productActions.js"></script>
</main>
<?php
include '../../includes/footer.php';
include("product_view.php");
?>

</body>
</html>
