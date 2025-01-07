<?php
$currentPage = basename($_SERVER['PHP_SELF']);

function getRoleActiveClass($page, $roleClass) {
    global $currentPage;
    return ($currentPage == $page) ? $roleClass : '';
}

// Checks if the page listed as an li on navbar is the current page,
// if so -> returns true, if not -> sets applying class as empty.
?>
 