<?php session_start() ?>
<div class="sidebar">
<div id="navbar-accent" class="decoration-bar"></div>
    <!-- <div class="menu-picture-container"> -->
        <img src="../../Pictures/logo.png" alt="logo" class="menu-picture">
        <div class="underlogo">
            <h2 class="name-txt"><?php echo $_SESSION['user_firstName'] . " " . $_SESSION['user_surname']?></h2>
            <?php
            $token = $_COOKIE['auth_token'];

            // Query the database to verify the token
            $stmt = $myPDO->prepare("SELECT s.staff_id, ut.role_name FROM staff_tokens ut
                                   JOIN staff s ON ut.staff_id = s.staff_id
                                   WHERE ut.token = ?");
            $stmt->execute([$token]);
            $user = $stmt->fetch();
            $user_role = '';
            switch($user['role_name']){
                case 'admin':
                    $user_role = 'Admin';
                    break;
                case 'employee':
                    $user_role = 'Employee';
                    break;
                case 'stockManager':
                    $user_role ='Stock Manager';
                    break;
                case 'manager':
                    $user_role = 'Manager';
                    break;
                case 'director':
                    $user_role = 'Director';
                    break;
            }
            ?>
            <p class="job-title-txt"><?php echo  $user_role?></p>
        </div>
        <ul class="nav-menu">
            <?php 
            include ("link_classes.php");

            switch ($user_role) {
                case "Employee":
                // Employee-specific navigation
                    echo "<li class='" . getRoleActiveClass('sales_index.php', 'active_emp') . "'><a href='../employee/sales_index.php'>New Sale</a></li>";
                    echo "<li class='" . getRoleActiveClass('stock.php', 'active_emp') . "'><a href=''>Stock</a></li>";
                    break;
                case "Admin":
                // Admin-specific navigation
                    echo "<li class='" . getRoleActiveClass('access_users.php', 'active_admin') . "'><a href='../admin/access_users.php'>Access Users</a></li>";
                    echo "<li class='" . getRoleActiveClass('new_account.php', 'active_admin') . "'><a href='../admin/new_account.php'>Create New User</a></li>";
                    echo "<li class='" . getRoleActiveClass('access_branches.php', 'active_admin') . "'><a href='../admin/access_branches.php'>Access Branches</a></li>";
                    echo "<li class='" . getRoleActiveClass('new_branch.php', 'active_admin') . "'><a href='../admin/new_branch.php'>Create New Branch</a></li>";
                    break;
                case "Stock Manager":
                    // Stock Manager-specific navigation
                    echo "<li class='" . getRoleActiveClass('stock_view.php', 'active_sm') . "'><a href=''>Stock View</a></li>";
                    echo "<li class='" . getRoleActiveClass('add_product.php', 'active_sm') . "'><a href=''>Add New Product</a></li>";
                    echo "<li class='" . getRoleActiveClass('orders.php', 'active_sm') . "'><a href=''>Orders</a></li>";
                    break;
                case "Manager":
                    // Manager-specific navigation
                    echo "<li class='" . getRoleActiveClass('employee_details.php', 'active_manager') . "'><a href=''>Employee Details</a></li>";
                    echo "<li class='" . getRoleActiveClass('branch_report.php', 'active_manager') . "'><a href=''>Branch Report</a></li>";
                    echo "<li class='" . getRoleActiveClass('previous_reports.php', 'active_manager') . "'><a href=''>Previous Reports</a></li>";
                    break;
                case "Director":
                    // Director-specific navigation
                    echo "<li class='" . getRoleActiveClass('dashboard.php', 'active_dir') . "'><a href=''>Dashboard</a></li>";
                    echo "<li class='" . getRoleActiveClass('reports.php', 'active_dir') . "'><a href=''>Reports</a></li>";
                    break;
                default:
                    break;
            }
            ?>
            <li class="bttn-logout"><a href="../login/logout.php">Logout</a></li>
        </ul>
    <!-- </div> -->
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