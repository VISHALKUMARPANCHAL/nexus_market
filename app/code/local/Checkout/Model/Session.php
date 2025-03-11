<?php
class Checkout_Model_Session extends Core_Model_Session
{
    public function getCart()
    {
        $cart_id = $this->get('cart_id');
        $cart_id = (is_null($cart_id)) ? 0 : $cart_id;
        $cart = Mage::getModel('checkout/cart')->load($cart_id);
        if (!$cart->getCartId()) {
            $cart->setCustomerId(0)
                ->setTotalAmount(0)
                ->setCreatedAt(date('Y-m-d H:i:s'))
                ->setUpdatedAt(date('Y-m-d H:i:s'))
                ->save();
            $this->set('cart_id', $cart->getCartId());
        }
        return $cart;
    }
}