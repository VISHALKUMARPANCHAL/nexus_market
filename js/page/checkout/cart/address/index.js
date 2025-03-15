function submitForm(price) {
    document.getElementById("shipping_price").value = price;
    document.getElementById("shippingForm").submit();
}

function submitPaymentForm() {
    document.getElementById("paymentForm").submit();
}

function ckeckTheCkeckbox() {
    const sameAddressCheckbox = document.getElementById('same-address');
    if (sameAddressCheckbox.checked) {
        document.getElementById('shipping-first_name').value = document.getElementById(
            'billing-first_name').value;
        document.getElementById('shipping-email').value = document.getElementById(
            'billing-email').value;
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
});