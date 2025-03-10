<?php
class Checkout_Model_Resource_Cart extends Core_Model_Resource_Abstract
{
    public function __construct()
    {
        $this->init('cart', 'cart_id');
    }
}