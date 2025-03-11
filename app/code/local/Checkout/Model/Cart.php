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
        return $this;
    }
    public function getItemCollection()
    {
        return Mage::getModel('checkout/cart_item')->getCollection()
            ->addFieldtoFilter('cart_id', $this->getCartId());
    }
    protected function _beforeSave()
    {
        $cart_items = $this->getItemCollection()->getData();
        $total = 0;
        foreach ($cart_items as $cart_item) {
            $total += $cart_item->getSubTotal();
        }
        $this->setTotalAmount($total);
    }
    public function removeItem($id)
    {
        $items = $this->getItemCollection()->getData();
        foreach ($items as $item) {
            if ($item->getItemId() == $id) {
                $item->delete();
            }
        }
        return $this;
    }
}