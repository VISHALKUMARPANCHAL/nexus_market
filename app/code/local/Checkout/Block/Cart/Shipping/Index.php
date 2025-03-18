<?php
class Checkout_Block_Cart_Shipping_Index extends Core_Block_Template
{
    public function getItems()
    {
        return Mage::getSingleton('checkout/session')
            ->getCart()
            ->getItemCollection()
            ->getData();
    }
    public function getCart()
    {
        return Mage::getSingleton('checkout/session')
            ->getCart();
    }
    public function getTotalAmount()
    {
        $items = $this->getItems();
        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += $item->getSubTotal();
        }
        return $totalAmount;
    }
    public function getShippingMethods()
    {
        return Mage::getModel('checkout/cart_shipping')->getShippingMethods();
    }
    public function getPaymentMethods()
    {
        return Mage::getModel('checkout/cart_payment')->getPaymentMethods();
    }
}