<?php
include("../../includes/dbconnect.php");
include("sales_basket.php");
// include("../../includes/header2.php");

if (!isset($_SESSION['basket'])) {
    header("Location: sales_index.php");
}


$basket = $_SESSION['basket'];
$currentBranch = 1;
try {
    if (!empty($basket)) {
        foreach ($basket as $item) {
            $productId = $item['ID'];
            $quantityPurchased = $item['quantity'];

            $sql = "UPDATE stock 
            SET quantity = quantity - :quantityPurchased 
            WHERE product = :productId AND branch = :branch";

            $stmt = $myPDO->prepare($sql);
            $stmt->bindParam(':quantityPurchased', $quantityPurchased, PDO::PARAM_INT);
            $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':branch', $currentBranch, PDO::PARAM_INT);
            $stmt->execute();
        }
    } 
} catch (PDOException $e) {
echo "Error updating stock: " . $e->getMessage();
exit;
}
?>


<div class="sales-tables-basket">
    <h2>Basket</h2>
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
            </tr>
        <?php } ?>
    </table>
    <div>
        <h3>Total: <?php echo array_sum(array_column($basket, 'price')) ?></h3>
    </div>
    <a href="sales_index.php"><button type="button">Start New Sale</button></a>
    <button type="button" >Produce an invoice</button>
</div>

<div id="successfulSaleModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal('successfulSaleModal')">&times;</span>
        <h2>Sale Successful</h2>
        <p>Do you want to print out the receipt?</p>
            <button type="submit" name="print_sale_receipt">Confirm</button>
            <button type="button" onclick="closeModal('successfulSaleModal')">Cancel</button>
        </form>
    </div>
</div>


<?php
include("modalStyleAndScript.php"); 
unset($_SESSION['basket']);

include("../../includes/footer.php");
?>