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

        const passwordInput = document.getElementById('inputSignupPassword');
        const confirmPasswordInput = document.getElementById('inputConfirmPassword');

        // Trigger password validation on input
        passwordInput.addEventListener('input', function () {
            validatePassword(this);
            validateConfirmPassword(confirmPasswordInput);
        });

        // Trigger confirm password validation on input
        confirmPasswordInput.addEventListener('input', function () {
            validateConfirmPassword(this);
        });
    });
})();

function validatePassword(input) {
    const password = input.value;

    // Check if the password meets the criteria
    if (
        password.length < 8 ||
        password.length > 20 ||
        !/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]/.test(password)
    ) {
        input.setCustomValidity(
            'Your password must be 8-20 characters long and include a mix of uppercase and lowercase letters, numbers, and special characters.'
        );
    } else {
        input.setCustomValidity('');
    }

    // Show the Password strength text and indicators only when the user has inputted something
    var passwordStrength = document.getElementById('passwordStrength');
    var lengthIndicator = document.getElementById('lengthIndicator');
    var uppercaseLowercaseIndicator = document.getElementById('uppercaseLowercaseIndicator');
    var numberIndicator = document.getElementById('numberIndicator');
    var specialCharacterIndicator = document.getElementById('specialCharacterIndicator');

    if (password.length > 0) {
        passwordStrength.style.display = 'block';
        lengthIndicator.style.display = 'block';
        uppercaseLowercaseIndicator.style.display = 'block';
        numberIndicator.style.display = 'block';
        specialCharacterIndicator.style.display = 'block';
    } else {
        passwordStrength.style.display = 'none';
        lengthIndicator.style.display = 'none';
        uppercaseLowercaseIndicator.style.display = 'none';
        numberIndicator.style.display = 'none';
        specialCharacterIndicator.style.display = 'none';
    }

    // Password strength calculation
    var strength = 0;

    // Length check
    if (password.length >= 8) {
        strength += 1;
        lengthIndicator.textContent = 'Length: ✔';
    } else {
        lengthIndicator.textContent = 'Length: ✘';
    }

    // Uppercase and lowercase letters check
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) {
        strength += 1;
        uppercaseLowercaseIndicator.textContent = 'Uppercase and Lowercase: ✔';
    } else {
        uppercaseLowercaseIndicator.textContent = 'Uppercase and Lowercase: ✘';
    }

    // Numbers check
    if (/\d/.test(password)) {
        strength += 1;
        numberIndicator.textContent = 'Numbers: ✔';
    } else {
        numberIndicator.textContent = 'Numbers: ✘';
    }

    // Special characters check
    if (/[!@#$%^&*()_+]/.test(password)) {
        strength += 1;
        specialCharacterIndicator.textContent = 'Special Characters: ✔';
    } else {
        specialCharacterIndicator.textContent = 'Special Characters: ✘';
    }

    // Display the overall strength indicator
    var strengthIndicator = document.getElementById('strengthIndicator');
    switch (strength) {
        case 0:
            strengthIndicator.textContent = 'Weak';
            break;
        case 1:
            strengthIndicator.textContent = 'Moderate';
            break;
        case 2:
            strengthIndicator.textContent = 'Strong';
            break;
        case 3:
        case 4:
            strengthIndicator.textContent = 'Very Strong';
            break;
        default:
            strengthIndicator.textContent = '';
    }

    // Do not update Confirm Password input automatically
    // Trigger confirm password validation when password changes
    validateConfirmPassword(document.getElementById('inputConfirmPassword'));
}

function validateConfirmPassword(confirmInput) {
    const passwordInput = document.getElementById('inputSignupPassword');
    const confirmPassword = confirmInput.value;

    // Check if the password input is not empty before validating the match
    if (passwordInput.value !== '' && passwordInput.value !== confirmPassword) {
        confirmInput.setCustomValidity('Passwords do not match.');
        document.getElementById('confirmPasswordIndicator').textContent = 'Passwords do not match.';
    } else {
        confirmInput.setCustomValidity('');
        document.getElementById('confirmPasswordIndicator').textContent = '';
    }
}


const signupModalLink = document.getElementById('signupModalLink');
const loginModalLink = document.getElementById('loginModalLink');
const forms = document.querySelectorAll('form');

    function onClickHandler(event) {
        event.preventDefault();
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        if (form.classList.contains('was-validated')) {
            form.classList.remove('was-validated');
        }
    });
}
signupModalLink.addEventListener('click', onClickHandler);
loginModalLink.addEventListener('click', onClickHandler);