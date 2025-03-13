<?php
class Checkout_Model_Cart_Shipping extends Core_Model_Abstract
{
    public function getShippingMethods()
    {
        $coupons = [
            "Standard Shipping"  => 0,
            "Express Shipping"    => 299,
            "Priority Shipping"    => 499
        ];
        return $coupons;
    }
}
