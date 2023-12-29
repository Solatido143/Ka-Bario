<?php
include ('api/auth.php');
?>

<?php
include ('includes/header.php');
?>

<?php
include ('includes/myprofilepage.php');
?>

<script>
    (() => {
        'use strict';
        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('.needs-validation');

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    } 

                    form.classList.add('was-validated');
                    
                }, false);
            });
        });
    })();

    function newPassword(input) {
        const newPassword = input.value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        const errorDiv = document.getElementById('passwordError');
        const cnfrm_errorDiv = document.getElementById('confirmPasswordError');

        if (newPassword !== '' && (newPassword.length < 8 || newPassword.length > 20 || !/^[a-zA-Z0-9]+$/.test(newPassword))) {
            input.setCustomValidity(
                'Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.'
            );
            errorDiv.textContent = 'Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.';
        } else {
            input.setCustomValidity('');
            errorDiv.textContent = '';

            // Validate password confirmation after checking new password
            newPasswordConfirmation(document.getElementById('confirmPassword'));
        }
    }


    function newPasswordConfirmation(input) {
        const confirmPassword = input.value;
        const newPassword = document.getElementById('inputnewPassword').value;
        const errorDiv = document.getElementById('confirmPasswordError');

        if (confirmPassword === '') {
            input.setCustomValidity('');
            errorDiv.textContent = '';
        } else if (newPassword === '') {
            input.setCustomValidity("Please enter a new password first.");
            errorDiv.textContent = "Please enter a new password first.";
        } else if (confirmPassword !== newPassword) {
            input.setCustomValidity("Passwords do not match.");
            errorDiv.textContent = 'Passwords do not match.';
        } else {
            input.setCustomValidity('');
            errorDiv.textContent = '';
        }
    }













    function togglePasswordVisibility(inputId) {
        const passwordInput = document.getElementById(inputId);
        const passwordVisibilityIcon = document.getElementById('passwordVisibilityIcon');

        // Toggle password visibility
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordVisibilityIcon.classList.remove('fa-eye-slash');
            passwordVisibilityIcon.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            passwordVisibilityIcon.classList.remove('fa-eye');
            passwordVisibilityIcon.classList.add('fa-eye-slash');
        }
    }
    function toggleretypePasswordVisibility(inputId) {
        const retypepasswordInput = document.getElementById(inputId);
        const retypepasswordVisibilityIcon = document.getElementById('retypepasswordVisibilityIcon');

        // Toggle password visibility
        if (retypepasswordInput.type === 'password') {
            retypepasswordInput.type = 'text';
            retypepasswordVisibilityIcon.classList.remove('fa-eye-slash');
            retypepasswordVisibilityIcon.classList.add('fa-eye');
        } else {
            retypepasswordInput.type = 'password';
            retypepasswordVisibilityIcon.classList.remove('fa-eye');
            retypepasswordVisibilityIcon.classList.add('fa-eye-slash');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const birthdateInput = document.getElementById('birthdate');
        const errorDiv = document.getElementById('birthdate-error');

        if (birthdateInput) {
            birthdateInput.addEventListener('input', function () {
            const birthdateValue = this.value;

            if (!this.checkValidity()) {
            errorDiv.textContent = 'Invalid date format (MM/DD/YYYY)';
            } else {
                errorDiv.textContent = '';

                // Calculate age
                const birthdate = new Date(birthdateValue);
                const today = new Date();
                const age = today.getFullYear() - birthdate.getFullYear();

                // Check if birthday has occurred this year
                if (today.getMonth() < birthdate.getMonth() || (today.getMonth() === birthdate.getMonth() && today.getDate() < birthdate.getDate())) {
                    age--;
                }
            }
            });
        }


    });
</script>

<?php
include ('includes/footer.php');
?>