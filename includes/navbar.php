<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>
<div class="sidebar">
<div id="navbar-accent" class="decoration-bar"></div>
        <img src="../../Pictures/logo.png" alt="logo" class="menu-picture">
        <div class="underlogo">
            <h2 class="name-txt"><?php echo $_SESSION['user_firstName'] . " " . $_SESSION['user_surname']?></h2>
            
            <?php
            // load the login token stored in cookies.
            $token = $_COOKIE['auth_token'];

            $stmt = $myPDO->prepare("SELECT s.staff_id, ut.role_name FROM staff_tokens ut
                                   JOIN staff s ON ut.staff_id = s.staff_id
                                   WHERE ut.token = ?");

            // get the staff id and user role from the token.

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
                    echo "<li class='" . getRoleActiveClass('productsEmployee.php', 'active_emp') . "'><a href='../employee/productsEmployee.php'>Stock</a></li>";
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
                    echo '<li><a href="#" id="addNewProductBtn">Add New Product</a></li>';
                    break;
                case "Manager":
                    // Manager-specific navigation
                    echo "<li class='" . getRoleActiveClass('employee_details.php', 'active_manager') . "'><a href='../manager/viewStaff.php'>Employee Details</a></li>";
                    echo "<li class='" . getRoleActiveClass('branch_report.php', 'active_manager') . "'><a href=''>Branch Report</a></li>";
                    // echo "<li class='" . getRoleActiveClass('previous_reports.php', 'active_manager') . "'><a href=''>Previous Reports</a></li>";
                    break;
                case "Director":
                    // Director-specific navigation
                    echo "<li class='" . getRoleActiveClass('director_home.php', 'active_dir') . "'><a href='../director/director_home.php'>Dashboard</a></li>";
                    echo "<li class='" . getRoleActiveClass('report.php', 'active_dir') . "'><a href='../director/report.php'>Reports</a></li>";
                    break;
                default:
                    break;
            }
            ?>
            <li class="bttn-logout"><a href="../login/logout.php">Logout</a></li>
        </ul>
</div>   

