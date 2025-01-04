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

$f_nameErr = $m_nameErr = $l_nameErr = $addressErr = $postcodeErr = $townErr = $bankErr = $sortcodeErr = $accountErr = "";
$f_name = $m_name = $l_name = $address = $post_code = $town = $bank = $sort_code = $account_number = "";

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    // Validation logic
    $fields = [
        "f_name" => ["err" => &$f_nameErr, "required" => true, "regex" => "/^\S+$/", "message" => "First name is required and cannot contain spaces."],
        "m_name" => ["err" => &$m_nameErr, "regex" => "/^\S*$/", "message" => "Middle name cannot contain spaces."],
        "l_name" => ["err" => &$l_nameErr, "required" => true, "regex" => "/^\S+$/", "message" => "Last name is required and cannot contain spaces."],
        "address" => ["err" => &$addressErr, "required" => true, "message" => "Address is required."],
        "post_code" => [
            "err" => &$postcodeErr,
            "required" => true,
            "regex" => "/^([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]?[A-Za-z])))) [0-9][A-Za-z]{2})$/",
            "message" => "Invalid post code format. Please make sure you use a space between the two parts of the postcode."
        ],
        "town" => ["err" => &$townErr, "required" => true, "message" => "Town is required."],
        // "bank" => ["err" => &$bankErr, "required" => true, "message" => "Bank name is required."],
        // "sort_code" => [
        //     "err" => &$sortcodeErr,
        //     "required" => true,
        //     "regex" => "/^\d{6}$/",
        //     "message" => "Sort code must be 6 digits with no dashes or spaces."
        // ],
        // "account_number" => [
        //     "err" => &$accountErr,
        //     "required" => true,
        //     "regex" => "/^\d{8}$/",
        //     "message" => "Account number must be 8 digits."
        // ]
    ];

    foreach ($fields as $field => $rules) {
        global $$field;
        $$field = test_input($_POST[$field] ?? "");

        if (!empty($rules["required"]) && empty($$field)) {
            $rules["err"] = $rules["message"];
            $isValid = false;
        } elseif (!empty($rules["regex"]) && !preg_match($rules["regex"], $$field)) {
            $rules["err"] = $rules["message"];
            $isValid = false;
        }
    }

    // Insert into the database if valid
    if ($isValid) {
        try {
            $sql = "INSERT INTO Customer (f_name, m_name, l_name, address, post_code, town)
            --  bank, sort_code, account_number)
                    VALUES (:f_name, :m_name, :l_name, :address, :post_code, :town)";
                    // -- , :bank, :sort_code, :account_number)";
            $stmt = $myPDO->prepare($sql);

            $stmt->execute([
                ':f_name' => $f_name,
                ':m_name' => $m_name,
                ':l_name' => $l_name,
                ':address' => $address,
                ':post_code' => $post_code,
                ':town' => $town,
                // ':bank' => $bank,
                // ':sort_code' => $sort_code,
                // ':account_number' => $account_number
            ]);

            header("Location: sales_chooseCustomer.php?success=1");
            exit;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<link rel="stylesheet" href="../../CSS/employee.css" media="screen and (min-width: 1025px)">
</header>
<body class="employee-background">

<?php
// include("../../includes/navbar.php");
?>

<main class="main-container">
    <div class="create-customer">
        <h1>Add New Customer</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
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

            <!-- <label for="bank">Bank:<span style="color: red">*</span></label><br>
            <input type="text" id="bank" name="bank" value="<?php echo htmlspecialchars($bank); ?>" required><br>
            <span class="error"><?php echo $bankErr; ?></span><br>

            <label for="sort_code">Sort Code:<span style="color: red">*</span></label><br>
            <input type="text" id="sort_code" name="sort_code" value="<?php echo htmlspecialchars($sort_code); ?>" required><br>
            <span class="error"><?php echo $sortcodeErr; ?></span><br>

            <label for="account_number">Bank Account:<span style="color: red">*</span></label><br>
            <input type="text" id="account_number" name="account_number" value="<?php echo htmlspecialchars($account_number); ?>" required><br>
            <span class="error"><?php echo $accountErr; ?></span><br> -->

            <button type="submit">Add Customer</button>
        </form>
    </div>
</main>

<?php 
include("modalStyleAndScript.php");
include("../../includes/footer.php");
?>
