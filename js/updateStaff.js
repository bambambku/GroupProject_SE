// updateStaff.js

function viewStaff(staffId) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../admin/get_staff_details.php?staff_id=' + staffId, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                
                // Check for errors
                if (response.error) {
                    alert(response.error);
                    return;
                }
                
                var staff = response.staff;
                var roles = response.roles;
                var branches = response.branches;
                
                // Populate the form with staff data
                document.getElementById('staff_id').value = staff.staff_id;
                document.getElementById('f_name').value = staff.f_name;
                document.getElementById('l_name').value = staff.l_name;
                document.getElementById('email').value = staff.email;
                document.getElementById('role_id').value = staff.role_id;
                document.getElementById('branch_id').value = staff.branch_id;

                // Populate the roles dropdown
                var roleSelect = document.getElementById('role_id');
                roleSelect.innerHTML = ''; // Clear existing options
                roles.forEach(function(role) {
                    var option = document.createElement('option');
                    option.value = role.ID;
                    option.text = role.name;
                    if (role.ID == staff.role_id) {
                        option.selected = true; // Set the current role as selected
                    }
                    roleSelect.appendChild(option);
                });

                // Populate the branches dropdown
                var branchSelect = document.getElementById('branch_id');
                branchSelect.innerHTML = ''; // Clear existing options
                branches.forEach(function(branch) {
                    var option = document.createElement('option');
                    option.value = branch.ID;
                    option.text = branch.name;
                    if (branch.ID == staff.branch_id) {
                        option.selected = true; // Set the current branch as selected
                    }
                    branchSelect.appendChild(option);
                });

                // Show the popup
                document.getElementById('popupForm').style.display = 'flex';
            } catch (e) {
                console.error('Invalid JSON response:', e);
                alert('Failed to load staff details.');
            }
        }
    };

    xhr.send();
}

function closePopup() {
    document.getElementById('popupForm').style.display = 'none';
}

// saveStaff function to send the updated staff details
function saveStaff() {
    var staffId = document.getElementById('staff_id').value;
    var fName = document.getElementById('f_name').value;
    var lName = document.getElementById('l_name').value;
    var email = document.getElementById('email').value;
    var roleId = document.getElementById('role_id').value;
    var branchId = document.getElementById('branch_id').value;

    // Check if all required fields are filled
    if (!staffId || !fName || !lName || !email || !roleId || !branchId) {
        alert('Please fill in all fields.');
        return;
    }

    // Create data to be sent in the POST request
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../admin/save_staff.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Form data to send to the server
    var data = 'staff_id=' + staffId + 
               '&f_name=' + encodeURIComponent(fName) + 
               '&l_name=' + encodeURIComponent(lName) + 
               '&email=' + encodeURIComponent(email) + 
               '&role_id=' + roleId + 
               '&branch_id=' + branchId;

    // Handle the response
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Check if the server returned a success message
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert('Staff details saved successfully');
                closePopup();
                location.reload(); // Optionally reload the page to show updated data
            } else {
                alert('Error saving details: ' + response.error);
            }
        } else {
            alert('Request failed. Please try again.');
        }
    };

    // Send the request with the data
    xhr.send(data);
}