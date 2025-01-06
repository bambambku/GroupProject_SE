<?php
session_start();

include ("../../query.php");

if ($_SESSION["user_role"] != 2){
    header("Location: ../login/logout.php");
}

$sql = "SELECT * FROM Product LEFT JOIN stock ON Product.ID = stock.product";
$stmt = $myPDO->prepare($sql);
$stmt->execute();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)">
    <link rel="stylesheet" href="..\..\CSS\stockManager.css">
    <title>Product View</title>
    <script defer src="../../js/tableDropSort.js"></script>
    <script defer src="../../js/productActions.js"></script>
</head>
<body id="stock-manager-background">
<?php include '../../includes/navbar.php'; ?>
<main class="main-container">
<h1>Products:</h1>
<div class="general-content-out">
    <div class="general-content-bttn-area">
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
    </div>            
</div>
</main>
<?php
include '../../includes/footer.php';
?>
</body>
</html>

