<?php
class Checkout_Controller_Cart_Shipping extends Core_Controller_Front_Action
{
    public function saveAction()
    {
        $data = $this->getRequest()->getParams();
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // die;
        Mage::getModel('checkout/session')
            ->getCart()
            ->setShippingMethod($data['method_shipping'])
            ->setShippingPrice($data['shipping_price'])
            ->save();
        $this->redirect('checkout/cart_address/index');
    }
}