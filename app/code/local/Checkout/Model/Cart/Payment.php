<?php
class Checkout_Model_Cart_Payment extends Core_Model_Abstract
{
    public function getPaymentMethods()
    {
        $payment = [
            "Pay on Delivery",
            "PayPal",
            "UPI",
            "Net Banking"
        ];
        return $payment;
    }
}
