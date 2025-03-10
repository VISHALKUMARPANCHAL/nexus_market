<?php
class Checkout_Model_Cart extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = 'Checkout_Model_Resource_Cart';
        $this->_collectionClass = 'Checkout_Model_Resource_Cart_Collection';
    }
    public function addProduct($product_id, $quantity)
    {
        Mage::getModel('checkout/cart_item')
            ->setCartId($this->getCartId())
            ->setProductId($product_id)
            ->setProductQuantity($quantity)
            ->save();
    }
}