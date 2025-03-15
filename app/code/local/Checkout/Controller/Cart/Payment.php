<?php
class Checkout_Controller_Cart_Payment extends Core_Controller_Front_Action
{
    public function saveAction()
    {
        $data = $this->getRequest()->getParams();
        Mage::getModel('checkout/session')
            ->getCart()
            ->setPaymentMethod($data['payment_method'])
            ->save();
        $this->redirect('checkout/cart_address/index');
    }
}