<?php
class Checkout_Model_Cart_Item extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = 'Checkout_Model_Resource_Cart_Item';
        $this->_collectionClass = 'Checkout_Model_Resource_Cart_Item_Collection';
    }
    protected function _beforeSave()
    {
        $cart_item = $this->getCollection()
            ->addFieldtoFilter('cart_id', $this->getCartId())
            ->addFieldtoFilter('product_id', $this->getProductId())
            ->getFirstItem();
        if ($cart_item->getItemId()) {
            if ($this->getItemId()) {
                $this->setProductQuantity($this->getProductQuantity());
            } else {
                $this->setProductQuantity($cart_item->getProductQuantity() + $this->getProductQuantity());
                $this->setItemId($cart_item->getItemId());
            }
        }
        $price = $this->getProduct()->getPrice();
        $this->setPrice($price);
        $this->setSubTotal($price * $this->getProductQuantity());
    }
    public function getProduct()
    {
        return Mage::getModel('catalog/product')->load($this->getProductId());
    }
}
