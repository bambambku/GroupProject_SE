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
include("../../includes/header2.php");

$f_nameErr = $m_nameErr = $l_nameErr = $addressErr = $postcodeErr = $townErr = "";
$f_name = $m_name = $l_name = $address = $post_code = $town = "";

$customerId = $_GET['adjust'] ?? null;

if ($customerId && is_numeric($customerId)) {
    try {
        $stmt = $myPDO->prepare("SELECT * FROM Customer WHERE ID = :id");
        $stmt->execute([':id' => $customerId]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($customer) {
            $f_name = $customer['f_name'];
            $m_name = $customer['m_name'];
            $l_name = $customer['l_name'];
            $address = $customer['address'];
            $post_code = $customer['post_code'];
            $town = $customer['town'];
        } else {
            echo "Customer not found.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid customer ID provided.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    function test_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $fields = [
        "f_name" => ["err" => &$f_nameErr, "required" => true, "message" => "First name is required."],
        "m_name" => ["err" => &$m_nameErr, "message" => ""],
        "l_name" => ["err" => &$l_nameErr, "required" => true, "message" => "Last name is required."],
        "address" => ["err" => &$addressErr, "required" => true, "message" => "Address is required."],
        "post_code" => ["err" => &$postcodeErr, "required" => true, "message" => "Post code is required."],
        "town" => ["err" => &$townErr, "required" => true, "message" => "Town is required."],
    ];

    foreach ($fields as $field => $rules) {
        global $$field;
        $$field = test_input($_POST[$field] ?? "");

        if (!empty($rules["required"]) && empty($$field)) {
            $rules["err"] = $rules["message"];
            $isValid = false;
        }
    }

    if ($isValid) {
        try {
            $sql = "UPDATE Customer 
                    SET f_name = :f_name, m_name = :m_name, l_name = :l_name, 
                        address = :address, post_code = :post_code, town = :town 
                    WHERE ID = :id";
            $stmt = $myPDO->prepare($sql);
            $stmt->execute([
                ':f_name' => $f_name,
                ':m_name' => $m_name,
                ':l_name' => $l_name,
                ':address' => $address,
                ':post_code' => $post_code,
                ':town' => $town,
                ':id' => $customerId
            ]);

            header("Location: sales_chooseCustomer.php?success=1");
            exit;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<title>Adjust Customer</title>
<link rel="stylesheet" href="../../CSS/employee.css" media="screen and (min-width: 1025px)">
<body class="employee-background">

<?php include("../../includes/navbar.php"); ?>

<main class="main-container">
    <div class="create-customer">
        <h1>Adjust Customer</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?adjust=$customerId"; ?>" method="POST">
            <label for="f_name">First Name:<span style="color: red">*</span></label><br>
            <input type="text" id="f_name" name="f_name" value="<?php echo htmlspecialchars($f_name); ?>" required><br>
            <span class="error"><?php echo $f_nameErr; ?></span><br>

            <label for="m_name">Middle Name:</label><br>
            <input type="text" id="m_name" name="m_name" value="<?php echo htmlspecialchars($m_name); ?>"><br>
            <span class="error"><?php echo $m_nameErr; ?></span><br>

            <label for="l_name">Last Name:<span style="color: red">*</span></label><br>
            <input type="text" id="l_name" name="l_name" value="<?php echo htmlspecialchars($l_name); ?>" required><br>
            <span class="error"><?php echo $l_nameErr; ?></span><br>

            <label for="address">Address:<span style="color: red">*</span></label><br>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required><br>
            <span class="error"><?php echo $addressErr; ?></span><br>

            <label for="post_code">Post Code:<span style="color: red">*</span></label><br>
            <input type="text" id="post_code" name="post_code" value="<?php echo htmlspecialchars($post_code); ?>" required><br>
            <span class="error"><?php echo $postcodeErr; ?></span><br>

            <label for="town">Town:<span style="color: red">*</span></label><br>
            <input type="text" id="town" name="town" value="<?php echo htmlspecialchars($town); ?>" required><br>
            <span class="error"><?php echo $townErr; ?></span><br>

            <button type="submit">Update Customer</button>
        </form>
    </div>
</main>
