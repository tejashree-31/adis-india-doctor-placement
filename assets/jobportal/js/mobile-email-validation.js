document.addEventListener('DOMContentLoaded', function () {

    const mobileInput = document.getElementById('mobile_no');
    const mobileError = document.getElementById('mobileError');

    if (!mobileInput || !mobileError) return;

    // Typing validation
    mobileInput.addEventListener('input', function () {

        let value = this.value;

        // If alphabet or special character typed
        if (/[^0-9]/.test(value)) {
            mobileError.innerText = 'Only numbers are allowed';
            mobileError.style.display = 'block';
        } else if (value.length > 0 && value.length < 10) {
            mobileError.innerText = 'Enter valid 10 digit mobile number';
            mobileError.style.display = 'block';
        } else {
            mobileError.style.display = 'none';
        }

        // Remove non-numbers
        this.value = value.replace(/[^0-9]/g, '');

        // Limit to 10 digits
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }

        // Hide error when exactly 10 digits
        if (this.value.length === 10) {
            mobileError.style.display = 'none';
        }
    });

});

// Submit validation
function validateMobile() {

    const mobileInput = document.getElementById('mobile_no');
    const mobileError = document.getElementById('mobileError');

    if (mobileInput.value.length !== 10) {
        mobileError.innerText = 'Enter valid 10 digit mobile number';
        mobileError.style.display = 'block';
        mobileInput.focus();
        return false;
    }

    return true;
}

// ========================= email ========================================//
document.addEventListener('DOMContentLoaded', function () {

    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');

    if (!emailInput || !emailError) return;

    // Typing validation
    emailInput.addEventListener('input', function () {

        const value = this.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (value !== '' && !emailRegex.test(value)) {
            emailError.innerText = 'Please enter a valid email address';
            emailError.style.display = 'block';
        } else {
            emailError.style.display = 'none';
        }
    });

});

// Submit validation
function validateEmail() {

    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');

    if (!emailInput || !emailError) return true;

    const email = emailInput.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email === '') {
        emailError.innerText = 'Email address is required';
        emailError.style.display = 'block';
        emailInput.focus();
        return false;
    }

    if (!emailRegex.test(email)) {
        emailError.innerText = 'Enter valid email address';
        emailError.style.display = 'block';
        emailInput.focus();
        return false;
    }

    emailError.style.display = 'none';
    return true;
}

document.addEventListener("DOMContentLoaded", function () {

    const fileInput = document.getElementById("profile_photo");
    const preview = document.getElementById("photoPreview");
    const icon = document.getElementById("defaultIcon");
    const circle = document.querySelector(".photo-circle");

    if (circle) {
        circle.addEventListener("click", function () {
            fileInput.click();
        });
    }

    if (fileInput) {
        fileInput.addEventListener("change", function () {

            if (this.files && this.files[0]) {

                const reader = new FileReader();

                reader.onload = function (e) {

                    preview.src = e.target.result;
                    preview.style.display = "block";
                    icon.style.display = "none";

                };

                reader.readAsDataURL(this.files[0]);
            }

        });
    }

});