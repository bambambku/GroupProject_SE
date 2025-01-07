document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registrationForm');
    
    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();  // Prevent form submission to handle validation

            // Get form fields
            const email = document.getElementById('email');
            const emailConfirm = document.getElementById('email-confirm');
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password-confirm');

            // Reset styles
            email.classList.remove('valid', 'invalid');
            emailConfirm.classList.remove('valid', 'invalid');
            password.classList.remove('valid', 'invalid');
            passwordConfirm.classList.remove('valid', 'invalid');

            let validForm = true;

            // Validate email match
            if (email.value === emailConfirm.value) {
                email.classList.add('valid');
                emailConfirm.classList.add('valid');
            } else {
                email.classList.add('invalid');
                emailConfirm.classList.add('invalid');
                validForm = false;
            }

            // Validate password match
            if (password.value === passwordConfirm.value) {
                password.classList.add('valid');
                passwordConfirm.classList.add('valid');
            } else {
                password.classList.add('invalid');
                passwordConfirm.classList.add('invalid');
                validForm = false;
            }

            // Only submit the form if everything is valid
            if (validForm) {
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
            }
        });
    }
});
