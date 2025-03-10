<?php
class Checkout_Model_Session extends Core_Model_Session
{
    public function getCart()
    {
        $cart_id = $this->get('cart_id');

        if ($cart_id == null) {
            $cart = Mage::getModel("checkout/cart")
                ->setCustomerId(0)
                ->setTotalAmount(0)
                ->setCreatedAt(date('Y-m-d H:i:s'))
                ->setUpdatedAt(date('Y-m-d H:i:s'))
                ->save();
            $this->set('cart_id', $cart->getCartId());
            return $this;
        } else {
            // echo "456";
            return Mage::getModel('checkout/cart')->load($cart_id);
            // return $this;
        }
    }
}