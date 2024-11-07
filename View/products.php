<?php
include ("../Model/dbconnect.php");
include ("../Model/query.php");

$products = makeQuerry("SELECT ID, name, description, price, weight, size, CPU, GPU, RAM, hard_drive FROM Product", $conn);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style-products-desktop.css">
    <link rel="stylesheet" href="style-desktop.css" media="screen and (min-width: 1025px)">
    
    <title>Product View</title>
</head>
<body>
    <h1>Products:</h1>
    <button id="modalButtonProducts">Create New</button>
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
            <button id="close">Close</button>
            <button id="save">Save</button>
        </form>
        
    </div>
    <?php  
    // Insert new product
    // $insertQuery = "INSERT INTO Product (name, description, price, weight, size, CPU, GPU, RAM, hard_drive) VALUES ('$name', '$description', '$price', '$weight', '$size', '$cpu', '$gpu', '$ram', '$hard_drive')";
    // makeQuerry($insertQuery, $conn);
    ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Weight</th>
            <th>Size</th>
            <th>CPU</th>
            <th>GPU</th>
            <th>RAM</th>
            <th>Hard Drive</th>
            <th>Actions</th>
        </tr>
        <?php
        if (!empty($products)) {
            foreach ($products as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                echo "<td>" . htmlspecialchars($row['weight']) . "</td>";
                echo "<td>" . htmlspecialchars($row['size']) . "</td>";
                echo "<td>" . htmlspecialchars($row['CPU']) . "</td>";
                echo "<td>" . htmlspecialchars($row['GPU']) . "</td>";
                echo "<td>" . htmlspecialchars($row['RAM']) . "</td>";
                echo "<td>" . htmlspecialchars($row['hard_drive']) . "</td>";
                echo "<td>";
                echo "<a href='edit.php?id=" . htmlspecialchars($row['ID']) . "'>Edit</a> | ";
                echo "<a href='details.php?id=" . htmlspecialchars($row['ID']) . "'>Details</a> | ";
                echo "<a href='delete.php?id=" . htmlspecialchars($row['ID']) . "' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11'>No products found</td></tr>";
        }
        ?>
    </table>
<script>
// Get the modal
var modal = document.getElementById("modalWindowProducts");

// Get the button that opens the modal
var btn = document.getElementById("modalButtonProducts");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
</body>
</html>
