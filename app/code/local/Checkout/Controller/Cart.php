<?php
class Checkout_Controller_Cart
{
    public function indexAction()
    {
        $session = Mage::getSingleton('core/session');
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
        $layout = Mage::getBlock('core/layout');
        $index = $layout->createBlock('checkout/cart_index')
            ->setTemplate('checkout/cart/index.phtml');
        $layout->getChild('content')->addChild('index', $index);
        $layout->toHtml();
    }
    public function addAction()
    {

        $request = Mage::getModel('core/request');
        $session = Mage::getSingleton('core/session');
        $product = $request->getParam('cart');
        if ($session->get('product') == null) {
        } else {
            $arr = $session->get('product');
        }
        if (array_key_exists($product['product_id'], $arr)) {
            $arr[$product['product_id']] = $arr[$product['product_id']] + $product['quantity'];
        } else {
            $arr[$product['product_id']] = $product['quantity'];
        }
        $session->set('cart', $arr);
    }
}