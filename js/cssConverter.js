
// Pass the PHP session value to JavaScript
let userRole = "<?php echo $_SESSION['user_role']; ?>";

function updateCss(role) {
    var accent = document.getElementById('navbar-accent');
    switch(role) {
        case 'Admin':
            accent.classList.add('admin-accent');
            break;
        case 'Manager':
            accent.classList.add('manager-accent');
            break;
        case 'Stock Manager':
            accent.classList.add('sm-accent');
            break;
        case 'Director':
            accent.classList.add('dir-accent');
            break;
        default:
            break;
    }
}

