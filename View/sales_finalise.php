<?php
include("../Model/query.php");
include("../Model/dbconnect.php");
include("../Model/sales_basket.php");

if (isset($_GET['add'])) {
    addToBasket($_GET['add']);
} elseif (isset($_GET['remove'])) {
    removeFromBasket($_GET['remove']);
}

$basket = $_SESSION['basket'];
$currentBranch = 1;

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
                <td>
                    <a href="sales_index.php?remove=<?php echo $product['ID']; ?>">Remove</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div>
        <h3>Total: <?php echo array_sum(array_column($basket, 'price')) ?></h3>
    </div>
    <a href="sales_index.php"><button type="button">Start New Sale</button></a>
    <button type="button" >Produce an invoice</button>
</div>

<!-- <div id="successfulSaleModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal('successfulSaleModal')">&times;</span>
        <h2>Sale Successful</h2>
        <p>Do you want to print out the receipt?</p>
            <button type="submit" name="print_sale_receipt">Confirm</button>
            <button type="button" onclick="closeModal('successfulSaleModal')">Cancel</button>
        </form>
    </div>
</div> -->


<?php include("../Model/modalStyleAndScript.php"); ?>