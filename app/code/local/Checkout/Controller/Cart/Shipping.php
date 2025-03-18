<?php
class Checkout_Controller_Cart_Shipping extends Core_Controller_Front_Action
{
    public function indexAction()
    {
        $layout = Mage::getBlock('core/layout');
        $index = $layout->createBlock('checkout/cart_shipping_index')
            ->setTemplate('checkout/cart/shipping/index.phtml');
        $layout->getChild('content')->addChild('index', $index);
        $layout->getChild('head')->addJs('page/checkout/cart/address/index.js');
        $layout->toHtml();
    }
    public function saveShippingAction()
    {
        $data = $this->getRequest()->getParams();
        Mage::getModel('checkout/session')
            ->getCart()
            ->setShippingMethod($data['method_shipping'])
            ->setShippingPrice($data['price_shipping'])
            ->save();
        $this->redirect('checkout/cart_shipping/index');
    }
    public function savePaymentAction()
    {
        $data = $this->getRequest()->getParams();
        Mage::getModel('checkout/session')
            ->getCart()
            ->setPaymentMethod($data['payment_method'])
            ->save();
        $this->redirect('checkout/cart_shipping/index');
    }
}