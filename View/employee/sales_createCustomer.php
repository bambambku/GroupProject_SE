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

$f_nameErr = $m_nameErr = $l_nameErr = $addressErr = $postcodeErr = $townErr = $bankErr = $sortcodeErr = $accountErr = "";
$f_name = $m_name = $l_name = $address = $post_code = $town = $bank = $sort_code = $account_number = "";

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    // First Name Validation
    if (empty($_POST["f_name"])) {
        $f_nameErr = "First name is required";
        $isValid = false;
    } elseif (preg_match("/\s/", $_POST["f_name"])) {
        $f_nameErr = "First name cannot contain spaces";
        $isValid = false;
    } else {
        $f_name = test_input($_POST["f_name"]);
    }

    // Middle Name Validation
    if (!empty($_POST["m_name"]) && preg_match("/\s/", $_POST["m_name"])) {
        $m_nameErr = "Middle name cannot contain spaces";
        $isValid = false;
    } else {
        $m_name = test_input($_POST["m_name"]);
    }

    // Last Name Validation
    if (empty($_POST["l_name"])) {
        $l_nameErr = "Last name is required";
        $isValid = false;
    } elseif (preg_match("/\s/", $_POST["l_name"])) {
        $l_nameErr = "Last name cannot contain spaces";
        $isValid = false;
    } else {
        $l_name = test_input($_POST["l_name"]);
    }

    // Address Validation
    if (empty($_POST["address"])) {
        $addressErr = "Address is required";
        $isValid = false;
    } else {
        $address = test_input($_POST["address"]);
    }

    // Postcode Validation
    if (empty($_POST["post_code"])) {
        $postcodeErr = "Post code is required";
        $isValid = false;
    } elseif (!preg_match("/^([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]?[A-Za-z])))) [0-9][A-Za-z]{2})$/", $_POST["post_code"])) {
        $postcodeErr = "Invalid post code format. Please make sure you use a space between the two parts of the postcode";
        $isValid = false;
    } else {
        $post_code = test_input($_POST["post_code"]);
    }

    // Town Validation
    if (empty($_POST["town"])) {
        $townErr = "Town is required";
        $isValid = false;
    } else {
        $town = test_input($_POST["town"]);
    }

    // Bank Validation
    if (empty($_POST["bank"])) {
        $bankErr = "Bank name is required";
        $isValid = false;
    } else {
        $bank = test_input($_POST["bank"]);
    }

    // Sort Code Validation
    if (empty($_POST["sort_code"])) {
        $sortcodeErr = "Sort code is required";
        $isValid = false;
    } elseif (!preg_match("/^\d{6}$/", $_POST["sort_code"])) {
        $sortcodeErr = "Sort code must be 6 digits with no dashes or spaces";
        $isValid = false;
    } else {
        $sort_code = test_input($_POST["sort_code"]);
    }

    // Account Number Validation
    if (empty($_POST["account_number"])) {
        $accountErr = "Account number is required";
        $isValid = false;
    } elseif (!preg_match("/^\d{8}$/", $_POST["account_number"])) {
        $accountErr = "Account number must be 8 digits";
        $isValid = false;
    } else {
        $account_number = test_input($_POST["account_number"]);
    }

    if ($isValid) {
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
        }
    }
}
?>

    <main class="main-container">
        <div class="create-customer">
            <h1>Add New Customer</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <label for="f_name">First Name:<span style="color: red">*</span></label><br>
                <input type="text" id="f_name" name="f_name" value="<?php echo htmlspecialchars($f_name); ?>" required><br>
                <span class="error"><?php echo $f_nameErr;?></span><br>

                <label for="m_name">Middle Name:</label><br>
                <input type="text" id="m_name" name="m_name" value="<?php echo htmlspecialchars($m_name); ?>"><br>
                <span class="error"><?php echo $m_nameErr;?></span><br>

                <label for="l_name">Last Name:<span style="color: red">*</span></label><br>
                <input type="text" id="l_name" name="l_name" value="<?php echo htmlspecialchars($l_name); ?>" required><br>
                <span class="error"><?php echo $l_nameErr;?></span><br>

                <label for="address">Address:<span style="color: red">*</span></label><br>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required><br>
                <span class="error"><?php echo $addressErr;?></span><br>

                <label for="post_code">Post Code:<span style="color: red">*</span></label><br>
                <input type="text" id="post_code" name="post_code" value="<?php echo htmlspecialchars($post_code); ?>" required><br>
                <span class="error"><?php echo $postcodeErr;?></span><br>

                <label for="town">Town:<span style="color: red">*</span></label><br>
                <input type="text" id="town" name="town" value="<?php echo htmlspecialchars($town); ?>" required><br>
                <span class="error"><?php echo $townErr;?></span><br>

                <label for="bank">Bank:<span style="color: red">*</span></label><br>
                <input type="text" id="bank" name="bank" value="<?php echo htmlspecialchars($bank); ?>" required><br>
                <span class="error"><?php echo $bankErr;?></span><br>

                <label for="sort_code">Sort Code:<span style="color: red">*</span></label><br>
                <input type="text" id="sort_code" name="sort_code" value="<?php echo htmlspecialchars($sort_code); ?>" required><br>
                <span class="error"><?php echo $sortcodeErr;?></span><br>

                <label for="account_number">Account Number:<span style="color: red">*</span></label><br>
                <input type="text" id="account_number" name="account_number" value="<?php echo htmlspecialchars($account_number); ?>" required><br>
                <span class="error"><?php echo $accountErr;?></span><br>

                <button type="submit">Add Customer</button>
            </form>
        </div>
    </main>
    <?php 
include("modalStyleAndScript.php"); 
include("../../includes/footer.php");
?>
</body>