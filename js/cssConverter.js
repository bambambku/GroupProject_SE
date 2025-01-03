

function updateCss(role) {
    var accent = document.getElementById('navbar-accent');
    var menu = document.querySelector('ul.nav-menu');
    switch(role) {
        case 'Admin':
            accent.classList.add('admin-accent');
            menu.classList.add('admin-menu');
            break;
        case 'Manager':
            accent.classList.add('manager-accent');
            menu.classList.add('manager-menu');
            break;
        case 'Stock Manager':
            accent.classList.add('sm-accent');
            menu.classList.add('sm-menu');
            break;
        case 'Director':
            accent.classList.add('dir-accent');
            menu.classList.add('dir-menu');
            break;
        default:
            break;
    }
}

