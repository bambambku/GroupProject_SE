<?php
include("../../Model/query.php");
include("../../Model/dbconnect.php");
include("sales_basket.php");
include("../../includes/header.php");
?>

<link rel="stylesheet" href="../../CSS/employee.css" media="screen and (min-width: 1025px)">
</header>

<body id="employee-background">

<?php include("../../includes/navbar.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $f_name = $_POST['f_name'];
    $m_name = $_POST['m_name'] ?? null;
    $l_name = $_POST['l_name'];
    $address = $_POST['address'];
    $post_code = $_POST['post_code'];
    $town = $_POST['town'];
    $bank = $_POST['bank'];
    $sort_code = $_POST['sort_code'];
    $account_number = $_POST['account_number'];

    try {
        $stmt = $conn->prepare(
            "INSERT INTO Customer (f_name, m_name, l_name, address, post_code, town, bank, sort_code, account_number) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssssssss",
            $f_name,
            $m_name,
            $l_name,
            $address,
            $post_code,
            $town,
            $bank,
            $sort_code,
            $account_number
        );

        if ($stmt->execute()) {
            echo "Customer added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();

        header("Location: sales_chooseCustomer.php?success=1");
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }}


?>


    <main class="main-container">
        <div class="create-customer">
            <h1>Add New Customer</h1>
            <form action="sales_createCustomer.php" method="POST">
                <label for="f_name">First Name:</label>
                <input type="text" id="f_name" name="f_name" required><br><br>

                <label for="m_name">Middle Name:</label>
                <input type="text" id="m_name" name="m_name"><br><br>

                <label for="l_name">Last Name:</label>
                <input type="text" id="l_name" name="l_name" required><br><br>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required><br><br>

                <label for="post_code">Post Code:</label>
                <input type="text" id="post_code" name="post_code" required><br><br>

                <label for="town">Town:</label>
                <input type="text" id="town" name="town" required><br><br>

                <label for="bank">Bank:</label>
                <input type="text" id="bank" name="bank" required><br><br>

                <label for="sort_code">Sort Code:</label>
                <input type="text" id="sort_code" name="sort_code" required><br><br>

                <label for="account_number">Account Number:</label>
                <input type="text" id="account_number" name="account_number" required><br><br>

                <button type="submit">Add Customer</button>
            </form>
        </div>
    </main>
    <?php 
include("modalStyleAndScript.php"); 
include("../../includes/footer.php");
?>
</body>