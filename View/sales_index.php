<?php
include("../Model/query.php");
include("../Model/dbconnect.php");
include("../Model/sales_basket.php");

if (isset($_GET['add'])) {
    addToBasket($_GET['add']);
} elseif (isset($_GET['remove'])) {
    removeFromBasket($_GET['remove']);
} elseif (isset($_GET['clear'])) {
    $_SESSION['basket'] = [];
}

$basket = $_SESSION['basket'];
$currentBranch = 1;

$searchTerm = "";
if (isset($_POST['search'])) {
    $searchTerm = "%" . $_POST['search'] . "%";
}

$sql = "SELECT product.ID, product.name, stock.quantity, product.price 
        FROM product, stock 
        WHERE stock.branch = ? AND stock.product = product.ID";

if ($searchTerm) {
    $sql .= " AND product.name LIKE ?";
}

$stmt = $conn->prepare($sql);
if ($searchTerm) {
    $stmt->bind_param("is", $currentBranch, $searchTerm);
} else {
    $stmt->bind_param("i", $currentBranch);
}
$stmt->execute();
$products = $stmt->get_result();

?>

<div class="sales-tables">
    <div class="sales-tables-stock">
        <h2>Stock</h2>
        <div class="form">
        <form action="" method="post">
            <label for="search">Search</label><br>
            <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($searchTerm ? $_POST['search'] : ''); ?>">
            <input type="submit" value="Search" name="salesSearch">
            <a href="sales_index.php">Clear</a>         
        </form>
        
        <table>
            <tr>
                <th>Product Name</th>
                <th>On Stock</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php while ($product = $products->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $product['name']?></td>
                    <td><?php echo $product['quantity']?></td>
                    <td><?php echo $product['price']?></td>
                    <td>
                        <a href="sales_index.php?add=<?php echo $product['ID']; ?>">Add</a>
                    </td>
                </tr>

                <?php }?>
        </table>
        </div>

        <div class="sales-tables-basket">
            <h2>Basket</h2>
            <a href="sales_index.php?clear"><button type="button">Clear</button></a>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($basket as $product) { ?>
                    <tr>
                        <td><?php echo $product['name']?></td>
                        <td><?php echo $product['quantity']?></td>
                        <td><?php echo $product['price']?></td>
                        <td>
                            <a href="sales_index.php?remove=<?php echo $product['ID']; ?>">Remove</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <div>
                <h3>Total: <?php echo array_sum(array_column($basket, 'price')) ?></h3>
            </div>
            <button type="button" onclick="openModal('finaliseSaleModal')">Finalise Sale</button>
        </div>
    </div>
</div>

<div id="finaliseSaleModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal('finaliseSaleModal')">&times;</span>
        <h2>Finalise Sale</h2>
        <p>Are you sure you want to finalise this sale?</p>
        
            <a href="sales_finalise.php"><button >Confirm</button></a>
            <button type="button" onclick="closeModal('finaliseSaleModal')">Cancel</button>
        
    </div>
</div>

<?php include("../Model/modalStyleAndScript.php"); ?>

    
