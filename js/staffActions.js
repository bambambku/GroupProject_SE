document.addEventListener('DOMContentLoaded', function() {
    var deleteButtons = document.querySelectorAll(".delete-button");

    deleteButtons.forEach(button => {
        button.onclick = function() {
            const staffId = this.id.replace("deleteButton", "");  // Ensure this gets the staffId

            if (confirm(`Are you sure you want to delete this staff member?`)) {
                // Log the staffId to verify it's correct
                console.log("Staff ID to delete:", staffId);

                // AJAX request to delete the staff member
                fetch('../../Model/delete_staff.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ staffId: staffId })  // Ensure correct data is being sent
                })
                .then(response => response.text())  // Get response as text for logging
                .then(text => {
                    console.log("Raw Response Text:", text);  // Log raw response text
                    try {
                        const data = JSON.parse(text);  // Try parsing the response as JSON
                        if (!data.failure) {
                            alert("Staff member deleted successfully.");
                            location.reload();  // Reload the page to reflect the changes
                        } else {
                            alert("Failed to delete staff member: " + data.message);
                        }
                    } catch (error) {
                        console.error("JSON Parse Error:", error);
                        alert("Failed to parse server response.");
                    }
                })
                .catch(error => {
                    console.error("Error occurred:", error);
                    alert("An error occurred while trying to delete the staff member.");
                });
            }
        };
    });
});
