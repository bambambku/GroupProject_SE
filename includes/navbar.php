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
            <li><a href="">New Sale</a></li>
            <li><a href="">Stock</a></li>
            <li class="bttn-logout"><a href="../login/logout.php">Logout</a></li>
        </ul>
    </div>
</div>   