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
        $discount = Mage::getModel('checkout/coupon')->calculateDiscount($this->getCouponCode(), $total);
        $this->setCouponDiscount($discount);
        if (!empty($this->getCouponDiscount())) {
            $total -= $this->getCouponDiscount();
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
    public function updateItem($itemId, $quantity)
    {
        $items = $this->getItemCollection()->getData();
        // echo '<pre>';
        // print_r($this);
        // print_r($items);
        // echo '</pre>';
        foreach ($items as $item) {
            if ($item->getItemId() == $itemId) {
                $item->setProductQuantity($quantity);
                $item->save();
            }
        }
        // die;
        return $this;
    }
}
