<?php
class Checkout_Controller_Cart_Shipping extends Core_Controller_Front_Action
{
    public function saveAction()
    {
        $data = $this->getRequest()->getParams();
        Mage::getModel('checkout/session')
            ->getCart()
            ->setShippingMethod($data['method_shipping'])
            ->setShippingPrice($data['price_shipping'])
            ->save();
        $this->redirect('checkout/cart_address/index');
    }
}