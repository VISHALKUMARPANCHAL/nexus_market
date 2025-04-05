<?php
class Checkout_Controller_Cart_Order extends Core_Controller_Customer_Action
{
    public function placeOrderAction()
    {
        $session = Mage::getSingleton('checkout/session');
        $cart = $session->getCart();
        if ($cart->getPaymentMethod() === 'PayPal') {
            $this->redirect('paypal/transaction/start');
        } else {
            $this->convertAction();
        }
    }
    public function convertAction()
    {
        $transactionId = $this->getRequest()->getQuery('transacionId');
        $session = Mage::getSingleton('checkout/session');
        $cart = $session->getCart();
        $order = Mage::getModel('checkout/convert_order')
            ->convert($cart);
        Mage::getModel('Sales/Order_Payment')
            ->setOrderId($order->getOrderId())
            ->setTransactionId($transactionId)
            ->setAmount($order->getTotalAmount())
            ->setPaymentMethod($order->getPaymentMethod())
            ->setStatus("completed")
            ->save();
        $cart->setIsActive(0)->save();
        $session->remove("cart_id");
        $this->redirect('catalog/product/list');
    }
}