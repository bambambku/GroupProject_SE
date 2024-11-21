<!-- TO DO: -SEARCH FUNCTION -SORT FUNCTION -->
<?php
include ("../../includes/dbconnect.php");
include ("../../query.php");
session_start();

$sql = "SELECT * FROM Product";
$stmt = $myPDO->prepare($sql);
$stmt->execute();



?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../CSS/style-products-desktop.css" media="screen and (min-width: 1025px)">
    <link rel="stylesheet" href="../../CSS/style-desktop.css" media="screen and (min-width: 1025px)">
    <link rel="stylesheet" href="../../CSS/stock-manager.css" media="screen and (min-width: 1025px)">
    <link rel="stylesheet" href="..\..\CSS\stockManager.css">
    <title>Product View</title>
    <script defer src="tableDropSort.js"></script>
</head>
<body id="stock-manager-background">
<?php include '../../includes/navbar.php'; ?>
<main class="main-container">
<h1>Products:</h1>
<div class="general-content-out">
    <div class="general-content-bttn-area">
         <button id="modalButtonProducts">Create New</button>
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
                <button type="button" id="closeButton">Close</button>
                <button type="button" id="addButton">Add</button>
            </form>       
        </div>
        <label for="sortDropdown">Sort by:</label>
        <select id="sortDropdown">
            <option selected="selected" value="none">-- SELECT --</option>
            <option value="price">Price</option>
            <option value="ram">RAM</option>
            <option value="hard_drive">Hard Drive</option>
            <option value="size">Size</option>
            <option value="weight">Weight</option>
        </select>
        <table id="laptopTable">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price (£)</th>
                <th>Weight (Kg)</th>
                <th>Size (In)</th>
                <th>CPU</th>
                <th>GPU</th>
                <th>RAM (GB)</th>
                <th>Hard Drive</th>
                <th>Actions</th>
            </tr>
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
                echo "<td>";
                echo "<button id='editButton" . htmlspecialchars($row['ID']) . htmlspecialchars($row['ID']) . "'\">Edit</button> | ";
                echo "<button id='details_" . htmlspecialchars($row['ID']) . "' id='details_" . htmlspecialchars($row['ID']) . "'>Details</button> | ";
                echo "<button id='deleteButton" . htmlspecialchars($row['ID']) . "' id='deleteButton" . htmlspecialchars($row['ID']) . "''>Delete</button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
            
        </table>
    </div>            
</div>
    <script src="../js/productActions.js"></script>
    </main>
<?php include '../../includes/footer.php'; ?>
</body>
</html>

