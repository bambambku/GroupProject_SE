<?php
$currentPage = basename($_SERVER['PHP_SELF']);

function getRoleActiveClass($page, $roleClass) {
    global $currentPage;
    return ($currentPage == $page) ? $roleClass : '';
}
?>