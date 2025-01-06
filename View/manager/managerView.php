<?php
session_start();

include ("../../query.php");

// var_dump($_SESSION);

// array(6) { ["user_role"]=> int(3) ["user_firstName"]=> string(8) "Michael " ["user_surname"]=> string(7) "Obrycki" ["email_address"]=> string(22) "mobrycki@terracore.com" ["user_id"]=> int(5) ["branch_id"]=> int(1) } 
if ($_SESSION["user_role"] != 3){
    header("Location: ../login/logout.php");
}

$sql = "SELECT * FROM Staff"; // Will probably add a where clause later to try and branch the currently logged in manager's branch with the staff members. 
$stmt = $myPDO->prepare($sql);
$stmt->execute();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Given that this is based off of Joe's Product Page I'm just gonna leave all CSS References to match his page so that the pages have a consistent feel. -->
    <!-- Will need to update CSS references later because I think in our wireframes it has different colours for the user roles. -->
    <link rel="stylesheet" href="../../CSS/style-desktop.css">
    <link rel="stylesheet" href="..\..\CSS\manager.css">
    <title>Product View</title>
    <!-- <script defer src="../../js/tableDropSort.js"></script> -->
    <script defer src="../../js/staffActions.js"></script>
</head>

<body class="manager-background">
    <?php include '../../includes/navbar.php'; ?>
    <main class="main-container">
        <h1>Staff Members:</h1>

        <div class="general-content-out">

            <div class="general-content-bttn-area">

            </div>

            <div class="general-content-in">
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
                        <label for="productStock">Quantity:</label><br>
                        <input type="number" id="productStock" name="productStock"><br>
                        <label for="productBranch">Branch:</label><br>
                        <input type="number" id="productBranch" name="productBranch"><br>
                        <button type="button" id="closeButton">Close</button>
                        <button type="button" id="addButton">Add</button>
                    </form>       
                </div>

                <!-- Save for later seems that I would have to change around Joe's Javascript to get this to work, I need to ask him later. -->
                <select id="sortSelect">
                    <option value="staffID">Staff ID</option>
                    <option value="forename">Forename</option>
                    <option value="surname">Surname</option>
                    <option value="branchID">Branch</option>
                    <option value="roleID">Role</option>
                </select>
                <button id="sortButton">Sort By</button>

                <!-- Changing the ID might break tableDropSort -->
                <table id="staffTable">
                    <thead>
                        <tr>
                            <th>Staff ID</th>
                            <th>Forname</th>
                            <th>Surname</th>
                            <th>Password (DELETE LATER - ONLY FOR TESTING)</th>
                            <th>Branch ID</th>
                            <th>Role ID</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row['staff_id'] . "</td>";
                            echo "<td>" . $row['f_name'] . "</td>";
                            echo "<td>" . $row['l_name'] . "</td>";
                            echo "<td>" . $row['password'] . "</td>";
                            echo "<td>" . $row['branch_id'] . "</td>";
                            echo "<td>" . $row['role_id'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>";
                            echo "<button class='editButton' data-id='" . htmlspecialchars($row['staff_id']) . "'>Edit</button> | ";
                            echo "<button id='deleteButton" . htmlspecialchars($row['staff_id']) . "''>Delete</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <div id="modalWindowProductsEdit" class="modal" style="display: none;">
                    <form>
                        <input type="hidden" id="editStaffID">

                        <label for="editStaffForename">Product name:</label><br>
                        <input type="text" id="editStaffForename" name="editStaffForename"><br>

                        <label for="editStaffSurname">Description:</label><br>
                        <input type="text" id="editStaffSurname" name="editStaffSurname"><br>

                        <!-- Maybe not allow manager to change password? Remove later if it becomes security risk -->
                        <label for="editPassword">Price:</label><br>
                        <input type="text" id="editPassword" name="editPassword"><br> 

                        <label for="editBranchID">Weight:</label><br>
                        <input type="text" id="editBranchID" name="editBranchID"><br>

                        <label for="editRoleID">Size:</label><br>
                        <input type="text" id="editRoleID" name="editRoleID"><br>

                        <label for="editEmail">CPU:</label><br>
                        <input type="text" id="editEmail" name="editEmail"><br>

                        <button type="button" id="closeButtonEdit">Close</button>
                        <button type="button" id="saveEditButton">Save</button>
                    </form>
                </div>
            </div>            
        </div>
    </main>
    <?php include '../../includes/footer.php';?>
</body>
</html>

