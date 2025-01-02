<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// logout and redirect to login if user is not logged in or not an employee 
if ($_SESSION["user_role"] != 1) {
    if ($_SESSION["user_role"]["name"] != 'Employee') {
    header("Location: ../login/login.php");
}}

include("../../includes/dbconnect.php");
include("sales_basket.php");
include("../../includes/header2.php");

// session_start();

if ($_SESSION['basket'] = []) {
    header("Location: sales_index.php");
    exit;
}   

try {
    if (isset($_GET['customer'])) {
        $sql = "SELECT * FROM Customer WHERE ID = :id";
        $stmt = $myPDO->prepare($sql);
        $stmt->bindParam(':id', $_GET['customer'], PDO::PARAM_INT);
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($customer) {
            $_SESSION['customer'] = $customer;
        }
    } else {
        unset($_SESSION['customer']);
    }

    // Fetch all customers
    $sql = "SELECT ID, f_name, m_name, l_name, address, post_code, town FROM Customer";
    $stmt = $myPDO->prepare($sql);
    $stmt->execute();
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit;
}
?>

<link rel="stylesheet" href="../../CSS/employee.css" media="screen and (min-width: 1025px)">
</header>

<body id="employee-background">

<!-- <?php include("../../includes/navbar.php"); ?> -->

<main class="main-container">
    <div class="choose-customer">
        <h1>Select a Customer</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Post Code</th>
                    <th>Town</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['ID']); ?></td>
                        <td><?php echo htmlspecialchars($row['f_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['m_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['l_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td><?php echo htmlspecialchars($row['post_code']); ?></td>
                        <td><?php echo htmlspecialchars($row['town']); ?></td>
                        <td>
                            <a href="sales_chooseCustomer.php?customer=<?php echo htmlspecialchars($row['ID']); ?>">
                                <button>Select</button>
                            </a>
                            <a href="sales_adjustCustomer.php?adjust=<?php echo htmlspecialchars($row['ID']); ?>">
                                <button>Adjust</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div>
            <p>Not on a list? <a href="sales_createCustomer.php"><button type="button">Create a new Customer</button></a>
             or <a href="invoice.php?guest=1"><button type="button">Buy as a Guest</button></a></p>
        </div>
    </div>

    <div id="chooseCustomerModal" class="modal">
        <div class="modal-content">
            <h2>Confirm Customer</h2>
            <p id="customerDetails"></p>
            <div class="modal-buttons">
                <a href="invoice.php">
                    <button>Confirm</button>
                </a>
                <a href="sales_chooseCustomer.php?cancel">
                    <button>Cancel</button>
                </a>
            </div>
        </div>
    </div>
</main>

<?php 
include("modalStyleAndScript.php"); 
include("../../includes/footer.php");
?>

<script>
    function showChooseCustomerModal(id, fName, lName, address, postCode, town) {
        const customerDetails = `
            <strong>ID:</strong> ${id}<br>
            <strong>First Name:</strong> ${fName}<br>
            <strong>Last Name:</strong> ${lName}<br>
            <strong>Address:</strong> ${address}<br>
            <strong>Post Code:</strong> ${postCode}<br>
            <strong>Town:</strong> ${town}
        `;
        document.getElementById("customerDetails").innerHTML = customerDetails;
        document.getElementById("chooseCustomerModal").style.display = "flex";
    }

    <?php if (isset($_SESSION['customer'])): ?>
        showChooseCustomerModal(
            <?php echo json_encode($_SESSION['customer']['ID']); ?>,
            <?php echo json_encode($_SESSION['customer']['f_name']); ?>,
            <?php echo json_encode($_SESSION['customer']['l_name']); ?>,
            <?php echo json_encode($_SESSION['customer']['address']); ?>,
            <?php echo json_encode($_SESSION['customer']['post_code']); ?>,
            <?php echo json_encode($_SESSION['customer']['town']); ?>
        );
    <?php else: ?>
        document.getElementById('chooseCustomerModal').style.display = 'none';
    <?php endif; ?>
</script>
