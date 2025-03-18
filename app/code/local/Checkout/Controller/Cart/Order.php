<?php
class Checkout_Controller_Cart_Order extends Core_Controller_Front_Action
{
    public function placeOrderAction()
    {
        $session = Mage::getSingleton('checkout/session');
        $cart = $session->getCart();
        Mage::getModel('checkout/cart_convert_order')
            ->convert($cart);
        $cart->setIsActive(0)->save();
        $session->remove("cart_id");
        $this->redirect('catalog/product/list');
    }
}