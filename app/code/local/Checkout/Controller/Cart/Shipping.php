<?php
class Checkout_Controller_Cart_Shipping extends Core_Controller_Front_Action
{
    public function saveAction()
    {
        $data = $this->getRequest()->getParams();
        Mage::getModel('checkout/session')
            ->getCart()
            ->setShippingMethod($data['shipping_method'])
            ->setShippingPrice($data['shipping_price'])
            ->save();
        $this->redirect('checkout/address/index');
    }
}
