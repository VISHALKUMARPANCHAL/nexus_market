<?php
class Checkout_Model_Session extends Core_Model_Session
{
    public function getCart()
    {
        $cart_id = $this->get('cart_id');
        $customer_id = $this->get('customer_id');
        $cart_id = (is_null($cart_id)) ? 0 : $cart_id;
        $customer_id = (is_null($customer_id)) ? 0 : $customer_id;
        $cart = Mage::getModel('checkout/cart')->load($cart_id);
        if (!$cart->getCartId()) {
            $cart->setcustomer_id($customer_id)
                ->setTotalAmount(0)
                ->setCreatedAt(date('Y-m-d H:i:s'))
                ->setUpdatedAt(date('Y-m-d H:i:s'))
                ->save();
            $this->set('cart_id', $cart->getCartId());
        }
        return $cart;
    }
}