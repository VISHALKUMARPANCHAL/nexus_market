<?php
class Checkout_Block_Cart_Address_Index extends Core_Block_Template
{
    // public function getItems()
    // {
    //     return Mage::getSingleton('checkout/session')
    //         ->getCart()
    //         ->getItemCollection()
    //         ->getData();
    // }
    public function getCart()
    {
        return Mage::getSingleton('checkout/session')
            ->getCart();
    }
    // public function getTotalAmount()
    // {
    //     $items = $this->getItems();
    //     $totalAmount = 0;
    //     foreach ($items as $item) {
    //         $totalAmount += $item->getSubTotal();
    //     }
    //     return $totalAmount;
    // }
    // public function getShippingMethods()
    // {
    //     return Mage::getModel('checkout/cart_shipping')->getShippingMethods();
    // }
    // public function getPaymentMethods()
    // {
    //     return Mage::getModel('checkout/cart_payment')->getPaymentMethods();
    // }
    public function getBillingAddress()
    {
        $cartId = $this->getCart()->getCartId();
        $addressData = Mage::getModel('checkout/cart_address')
            ->getCollection()
            ->addFieldToFilter('cart_id', $cartId)
            ->addFieldToFilter('address_type', 'billing')
            ->getFirstItem();
        return $addressData;
    }
    public function getShippingAddress()
    {
        $cartId = $this->getCart()->getCartId();
        $addressData = Mage::getModel('checkout/cart_address')
            ->getCollection()
            ->addFieldToFilter('cart_id', $cartId)
            ->addFieldToFilter('address_type', 'shipping')
            ->getFirstItem();
        return $addressData;
    }
    public function getIsAddressSame()
    {
        $billingAddress = $this->getBillingAddress()->getData();
        $shippingAddress = $this->getShippingAddress()->getData();
        if (empty($billingAddress) && empty($shippingAddress)) {
            return false;
        }
        // Mage::log($billingAddress);
        // Mage::log($shippingAddress);
        // die;
        unset($billingAddress['address_type']);
        unset($shippingAddress['address_type']);
        unset($billingAddress['address_id']);
        unset($shippingAddress['address_id']);
        unset($billingAddress['updated_at']);
        unset($billingAddress['created_at']);
        unset($shippingAddress['updated_at']);
        unset($shippingAddress['created_at']);
        return ($billingAddress === $shippingAddress);
    }
}