class FormValidator {
    constructor(form) {
        this.form = form;
        this.validationRules = {
            "validate-email": this.validateEmail,
            "validate-phoneNumber": this.validateNumber,
            "validate-alphabet": this.validateAlphabet,
            "validate-address": this.validateAddress,
            "validate-ZipCode": this.validateZipCode,
            "validate-required": this.validateRequired
        };
        this.observeInputs();
        this.setupFormSubmission();
    }

    validateEmail(input) {
        const emailPattern = /^\S+@\S+\.\S+$/;
        return emailPattern.test(input.value) ? "" : "Invalid Email format";
    }

    validateNumber(input) {
        return /^[6-9][0-9]{9}$/.test(input.value) ? "" : "Invalid Phone Number format";
    }

    validateRequired(input) {
        return input.value.trim() ? "" : "This field is required";
    }
    validateAlphabet(input) {
        return /^[A-Za-z]+$/.test(input.value) ? "" : "only alphabets are allowed";
    }
    validateAddress(input) {
        return /^[A-Za-z0-9_\s]+$/.test(input.value) ? "" : "Invalid Address format";
    }
    validateZipCode(input) {
        return /^[0-9]{5,10}$/.test(input.value) ? "" : "Invalid Zip Code format";
    }

    validateInput(input) {
        if (input.disabled) {
            this.showError(input, ""); // Clear errors for disabled fields
            return;
        }
    
        let errorMessage = "";
        Object.keys(this.validationRules).forEach((rule) => {
            if (input.classList.contains(rule)) {
                let error = this.validationRules[rule](input);
                if (error) errorMessage = error; // Only last error is shown
            }
        });
    
        this.showError(input, errorMessage);
        this.toggleSubmitButton();
    }
    

    showError(input, message) {
        let errorSpan = input.nextElementSibling;
        if (!errorSpan.tagName.toLowerCase() === "span" || !errorSpan.classList.contains("error-message")) {
            errorSpan = document.createElement("span");
            errorSpan.classList.add("error-message", "text-danger", "mt-1");
            input.insertAdjacentElement("afterend", errorSpan);
        }
        errorSpan.textContent = message;
    }
    toggleSubmitButton() {
        const allInputs = this.form.querySelectorAll("input");

        let isValid = true;

        allInputs.forEach((input) => {

            if (input.nextElementSibling && input.nextElementSibling.classList.contains("error-message") &&
                input.nextElementSibling.textContent !== "") {
                isValid = false;
            }
        });

        const submitButton = this.form.querySelector("button[type='submit']");
        if (submitButton) {
            submitButton.disabled = !isValid;
        }
    }

    observeInputs() {
        document.addEventListener("input", (event) => {
            if (event.target.tagName === "INPUT" || event.target.tagName === "SELECT") {
                this.validateInput(event.target);
            }
        });

        let observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.tagName === "INPUT" || node.tagName === "SELECT") {
                        this.validateInput(node);
                    }
                });
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
    setupFormSubmission() {
        this.form.addEventListener("submit", (event) => {
            let isValid = true;
            const allInputs = this.form.querySelectorAll("input,select");

            allInputs.forEach((input) => {
               
                this.validateInput(input);
                if (input.nextElementSibling && input.nextElementSibling.textContent !== "") {
                    isValid = false;
                }
            });

            if (!isValid) {
                event.preventDefault();
            }
        });
    }
}




function ckeckTheCkeckbox() {
    const sameAddressCheckbox = document.getElementById('same-address');
    if (sameAddressCheckbox.checked) {
        document.getElementById('shipping-first_name').value = document.getElementById(
            'billing-first_name').value;
        document.getElementById('shipping-last_name').value = document.getElementById(
            'billing-last_name').value;
        document.getElementById('shipping-phone_number').value = document.getElementById(
            'billing-phone_number').value;
        document.getElementById('shipping-street_address').value = document.getElementById(
            'billing-street_address').value;
        document.getElementById('shipping-city').value = document.getElementById('billing-city')
            .value;
        document.getElementById('shipping-state').value = document.getElementById('billing-state')
            .value;
        document.getElementById('shipping-zip').value = document.getElementById('billing-zip')
            .value;
        document.getElementById('shipping-country').value = document.getElementById(
            'billing-country').value;
        document.querySelectorAll('[name^="shipping"]').forEach(field => {
            field.disabled = true;
        });
    } else {
        document.querySelectorAll('[name^="shipping"]').forEach(field => {
            field.disabled = false;
        });
    }
}
document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('same-address').addEventListener('change', function() {
        ckeckTheCkeckbox();
    });
    ckeckTheCkeckbox();
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const creditCardForm = document.getElementById('credit-card-form');

    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            if (this.id === 'credit_card') {
                creditCardForm.style.display = 'block';
            } else {
                creditCardForm.style.display = 'none';
            }
        });
    });
    document.querySelectorAll("form").forEach((form) => {
        new FormValidator(form);
    });
});



