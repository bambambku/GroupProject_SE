<?php
include ('../../includes/dbconnect.php');
include '../../includes/navbar.php'; 

include('../../includes/verify_user.php');


include ("../../query.php");


$sql = "SELECT * FROM Product LEFT JOIN stock ON Product.ID = stock.product";
$stmt = $myPDO->prepare($sql);
$stmt->execute();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../CSS/style-desktop.css">
    <link rel="stylesheet" href="../../CSS/stockManager.css">
    <title>Product View</title>
    <script defer src="../../js/tableDropSort.js"></script>
    <script defer src="../../js/productActions.js"></script>
    <script src="../../js/cssConverter.js"></script>
    <script>updateCss("Stock Manager");</script>
</head>
<body id="stock-manager-background">
<main class="main-container">
<h1>Products:</h1>
<div class="general-content-out">
    <div class="general-content-bttn-area">
    </div>
    <div class="general-content-in">
    <div id="modalWindowProducts" class="modal">
    <form>
        <input type="hidden" id="editProductId">
        
        <div>
            <label for="productName">Product name:</label><br>
            <input type="text" id="productName" name="productName">
        </div>
        
        <div>
            <label for="productDescription">Description:</label><br>
            <input type="text" id="productDescription" name="productDescription">
        </div>

        <div>
            <label for="productPrice">Price:</label><br>
            <input type="text" id="productPrice" name="productPrice">
        </div>

        <div>
            <label for="productWeight">Weight:</label><br>
            <input type="text" id="productWeight" name="productWeight">
        </div>

        <div>
            <label for="productSize">Size:</label><br>
            <input type="text" id="productSize" name="productSize">
        </div>

        <div>
            <label for="productCPU">CPU:</label><br>
            <input type="text" id="productCPU" name="productCPU">
        </div>

        <div>
            <label for="productGPU">GPU:</label><br>
            <input type="text" id="productGPU" name="productGPU">
        </div>

        <div>
            <label for="productRAM">RAM:</label><br>
            <input type="text" id="productRAM" name="productRAM">
        </div>

        <div>
            <label for="productHardDrive">Hard-Drive:</label><br>
            <input type="text" id="productHardDrive" name="productHardDrive">
        </div>

        <div>
            <label for="productStock">Quantity:</label><br>
            <input type="number" id="productStock" name="productStock">
        </div>

        <div>
            <label for="productBranch">Branch:</label><br>
            <input type="number" id="productBranch" name="productBranch">
        </div>

        <div>
            <button type="button" id="closeButton">Close</button>
            <button type="button" id="addButton">Add</button>
        </div>
    </form>       
</div>

        <select id="sortSelect">
        <option value="lowStock">Low Stock</option>
        <option value="priceAsc">Price Ascending</option>
        <option value="priceDesc">Price Descending</option>
        </select>
        <button id="sortButton">Sort By</button>
        <table id="laptopTable">
            <thead>
                <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price (£)</th>
                <th>Weight</th>
                <th>Size</th>
                <th>CPU</th>
                <th>GPU</th>
                <th>RAM</th>
                <th>Hard Drive</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
            <tbody>
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['weight'] . "</td>";
                echo "<td>" . $row['size'] . "</td>";
                echo "<td>" . $row['CPU'] . "</td>";
                echo "<td>" . $row['GPU'] . "</td>";
                echo "<td>" . $row['RAM'] . "</td>";
                echo "<td>" . $row['hard_drive'] . "</td>";
                echo "<td>" . ($row['quantity'] ? $row['quantity'] : 'N/A') . "</td>";
                echo "<td>";
                echo "<button class='editButton' data-id='" . htmlspecialchars($row['ID']) . "'>Edit</button> | ";
                echo "<button id='deleteButton" . htmlspecialchars($row['ID']) . "''>Delete</button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
        <div id="modalWindowProductsEdit" class="modal" style="display: none;">
    <form>
        <input type="hidden" id="editProductId">
        <div>
            <label for="editProductName">Product name:</label><br>
            <input type="text" id="editProductName" name="editProductName">
        </div>
        <div>
            <label for="editProductDescription">Description:</label><br>
            <input type="text" id="editProductDescription" name="editProductDescription">
        </div>
        <div>
            <label for="editProductPrice">Price:</label><br>
            <input type="text" id="editProductPrice" name="editProductPrice">
        </div>
        <div>
            <label for="editProductWeight">Weight:</label><br>
            <input type="text" id="editProductWeight" name="editProductWeight">
        </div>
        <div>
            <label for="editProductSize">Size:</label><br>
            <input type="text" id="editProductSize" name="editProductSize">
        </div>
        <div>
            <label for="editProductCPU">CPU:</label><br>
            <input type="text" id="editProductCPU" name="editProductCPU">
        </div>
        <div>
            <label for="editProductGPU">GPU:</label><br>
            <input type="text" id="editProductGPU" name="editProductGPU">
        </div>
        <div>
            <label for="editProductRAM">RAM:</label><br>
            <input type="text" id="editProductRAM" name="editProductRAM">
        </div>
        <div>
            <label for="editProductHardDrive">Hard Drive:</label><br>
            <input type="text" id="editProductHardDrive" name="editProductHardDrive">
        </div>
        <div>
            <label for="editProductStock">Quantity:</label><br>
            <input type="number" id="editProductStock" name="editProductStock">
        </div>
        <div>
            <button type="button" id="closeButtonEdit">Close</button>
            <button type="button" id="saveEditButton">Save</button>
        </div>
    </form>
</div>

    </div>            
</div>
</main>
<?php
include '../../includes/footer.php';
?>
</body>
</html>

