document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('newBranchForm');
    
    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();  

            // Get form fields
            
                console.log("Form is valid, submitting...");

                // Send AJAX request to the same page
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '', true);  // Same page request
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        alert(xhr.responseText);  // Display response in alert for user feedback
                    } else {
                        console.error('AJAX Error:', xhr.statusText);
                    }
                };

                // Prepare form data
                const formData = new FormData(form);
                xhr.send(new URLSearchParams(formData).toString());  // Correctly send data as URL-encoded
            
        });
    }
});
