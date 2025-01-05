<?php

// Include PDO connection to SQLite
require_once 'dbconnect.php';

if (isset($_COOKIE['auth_token'])) {
    // Get the token from the cookie
    $token = $_COOKIE['auth_token'];

    // Query the database to verify the token
    $stmt = $myPDO->prepare("SELECT s.staff_id, ut.role_name FROM staff_tokens ut
                           JOIN staff s ON ut.staff_id = s.staff_id
                           WHERE ut.token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();



    if ($user) {

        $currentPage = $_SERVER['REQUEST_URI'];
        
        if (strpos($currentPage, $user['role_name']) === false) {       
            header("Location: ../login/logout.php");
        } 

    } else {
        header("Location: ../login/logout.php");
    }
} else{
    header("Location: ../login/logout.php");
}
//     } else {
//         header("Location: ../login/logout.php");
//         exit;
//     }
// } else {
//     header("Location: ../login/logout.php");
//     exit;
// }
