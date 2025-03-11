<?php
class Checkout_Block_Cart_Index extends Core_Block_Template
{
    public function getItems()
    {
        return Mage::getSingleton('checkout/session')
            ->getCart()
            ->getItemCollection()
            ->getData();
    }
    public function getTotalAmount()
    {
        return Mage::getSingleton('checkout/session')->getCart();
    }
}