<div class="decoration-bar"></div>
<div class="sidebar">
    <div class="menu-picture-container">
        <img src="../../Pictures/logo.png" alt="logo" class="menu-picture">
        <div class="underlogo">
            <h2 class="name-txt"><?php echo $_SESSION['user_firstName'] . " " . $_SESSION['user_surname']?></h2>
            <?php 
            
            $sql2 = "SELECT name FROM Role WHERE ID = :id";
            $stmt2 = $myPDO->prepare($sql2);  
            $stmt2->bindParam(':id', $_SESSION['user_role'], PDO::PARAM_INT);
            $stmt2->execute();
            $user_role = $stmt2->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_role']=$user_role;
            ?>
            <p class="job-title-txt"><?php echo  $_SESSION['user_role']['name']?></p>
        </div>
        <ul class="menu">
            <?php 
            switch($_SESSION['user_role']['name']){
                case("Employee"):
                    echo "<li><a href='../employee/sales_index.php'>New Sale</a></li>";
                    echo "<li><a href=''>Stock</a></li>";
                    break;
                case("Admin"):
                    echo "<li><a href=''>Access Users</a></li>";
                    echo "<li><a href=''>Create New User</a></li>";
                    echo "<li><a href=''>Branches</a></li>";
                    break;
                case("Stock Manager"):
                    echo "<li><a href=''>Stock View</a></li>";
                    echo "<li><a href=''>Add New Product</a></li>";
                    echo "<li><a href=''>Orders</a></li>";
                    break;
                case("Manager"):
                    echo "<li><a href=''>Employee Details</a></li>";
                    echo "<li><a href=''>Branch Report</a></li>";
                    echo "<li><a href=''>Previous Reports</a></li>";
                    break;
                case("Director"):
                    echo "<li><a href=''>Dashboard</a></li>";
                    echo "<li><a href=''>Reports</a></li>";
                    break;
                default:
                    break;
            }
            ?>
            <li class="bttn-logout"><a href="../login/logout.php">Logout</a></li>
        </ul>
    </div>
</div>   

<!-- 

CREATE DYNAMIC NAVBAR BASED ON USER ROLE
===========================================
If the user is Employee {
    Set the '<ul class="menu"> ... </ul> to have only the employee benchmark pages / actions
} else if {
    ... and so on...
}


Manager:
===========
[|] Employee Details
[|] Branch Report
[|] Previous Reports
[x] Sign Out

Director: 
===========
[] Dashboard
[] Reports
[x] Sign Out


EMPLOYEE:
==========
[|] New Sale
[|] Stock
[x] Sign Out

ADMIN:
==========
[|] Access Users
[|] Create New User
[|] Branches
[x] Sign Out

Stock Manager:
==============
[|] Stock View
[|] Add New Product
[|] Orders
[x] Sign Out

* ALL BASED ON MOCKPLUS WIREFRAME { https://rp.mockplus.com/editor/4p5Fn3_WL/kWbvBYf71 } AS OF { 21/11/2024 } *

-->