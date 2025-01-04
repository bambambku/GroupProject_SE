

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

function viewRecord(staff_id) {
    alert("View record with ID: " + staff_id);
}

function delRecord(staff_id) {
    if (confirm("Are you sure you want to delete this record?")) {
        console.log("Deleted record with ID: " + staff_id);
    }
}

/////////////////////////// TESTING FOR POPUPS //////////////////////////////

function showDeleteModal(staffId) {
    // Store the user ID for later use in the delete function
    window.selectedUserId = staffId;
    document.getElementById('deleteModal').style.display = "block";
}

// Close the modal
function closeModal() {
    document.getElementById('deleteModal').style.display = "none";
}

// If Cancel is clicked, close the modal
function cancelDelete() {
    closeModal();
}

// If Delete is clicked, make the AJAX request to delete the user
function deleteUser() {
    // Send an AJAX request to the PHP script to delete the user
    var userId = window.selectedUserId;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../../includes/delete_user.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Send the user ID to the server
    xhr.onload = function() {
        if (xhr.status == 200) {
            // Update the modal content based on the response from PHP
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                document.getElementById('modalTitle').textContent = "Successfully deleted the user!";
                document.getElementById('modalButtons').innerHTML = "<button onclick='closeModal()'>OK</button>";
            } else {
                document.getElementById('modalTitle').textContent = "Error: " + response.message;
                document.getElementById('modalButtons').innerHTML = "<button onclick='closeModal()'>OK</button>";
            }
        }
    };

    xhr.send("user_id=" + userId); // Send the user ID
}