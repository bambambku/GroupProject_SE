<!-- TO DO: -SEARCH FUNCTION -SORT FUNCTION -ADD NEW PRODUCT-->
<?php
include ("../Model/dbconnect.php");
include ("../Model/query.php");

$products = makeQuery("SELECT ID, name, description, price, weight, size, CPU, GPU, RAM, hard_drive FROM Product", $conn);

$data = json_decode(file_get_contents("php://input"), true);
if (!empty($data)) {
    // Get data values
    $name = $data['name'];
    $description = $data['description'];
    $price = $data['price'];
    $weight = $data['weight'];
    $size = $data['size'];
    $CPU = $data['CPU'];
    $GPU = $data['GPU'];
    $RAM = $data['RAM'];
    $hard_drive = $data['hard_drive'];
    $insertQuery = "INSERT INTO Product (name, description, price, weight, size, CPU, GPU, RAM, hard_drive)
                    VALUES ('$name', '$description', '$price', '$weight', '$size', '$CPU', '$GPU', '$RAM', '$hard_drive')";

    if (makeQuery($insertQuery, $conn)) {
        echo "success";
    } else {
        echo "Error: " . $conn->error;
    }
}
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
            <button type="button" id="closeButton">Close</button>
            <button type="button" id="addButton">Add</button>
        </form>
        
    </div>
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
                echo "<button id='editButton" . htmlspecialchars($row['ID']) . htmlspecialchars($row['ID']) . "'\">Edit</button> | ";
                echo "<button id='details_" . htmlspecialchars($row['ID']) . "' id='details_" . htmlspecialchars($row['ID']) . "'>Details</button> | ";
                echo "<button id='deleteButton" . htmlspecialchars($row['ID']) . "' id='deleteButton" . htmlspecialchars($row['ID']) . "' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</button>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11'>No products found</td></tr>";
        }
        ?>
    </table>
<script>
var modal = document.getElementById("modalWindowProducts");
var openBtn = document.getElementById("modalButtonProducts");
// Open Modal
openBtn.onclick = function() {
    modal.style.display = "flex";
}

// Close Modal
var closeBtn = document.getElementById("closeButton");
closeBtn.onclick = function() {
  modal.style.display = "none";
}

// Add Product
var addBtn = document.getElementById("addButton");

addBtn.onclick = async function() {
    const productName = document.getElementById("productName").value;
    const productDescription = document.getElementById("productDescription").value;
    const productPrice = document.getElementById("productPrice").value;
    const productWeight = document.getElementById("productWeight").value;
    const productSize = document.getElementById("productSize").value;
    const productCPU = document.getElementById("productCPU").value;
    const productGPU = document.getElementById("productGPU").value;
    const productRAM = document.getElementById("productRAM").value;
    const productHardDrive = document.getElementById("productHard-Drive").value;
    // Validation for fields, Don't allow null values etc


    // Send AJAX request to add the product
    const response = await fetch('products.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            name: productName,
            description: productDescription,
            price: productPrice,
            weight: productWeight,
            size: productSize,
            CPU: productCPU,
            GPU: productGPU,
            RAM: productRAM,
            hard_drive: productHardDrive
        })
    });
    window.location.reload();
};


// Edit Product
var editBtn = document.getElementById("editButton");
editBtn.onclick = function() {
    console.log("Edit Pressed");
}

// Delete Product
var deleteBtn = document.getElementById("deleteButton");
deleteBtn.onclick = function() {
    console.log("Delete Pressed");
}


</script>
</body>
</html>
