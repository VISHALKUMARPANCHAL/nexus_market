<?php
class Checkout_Controller_Cart extends Core_Controller_Front_Action
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
        $data = $this->getRequest()->getParams();
        Mage::getSingleton('checkout/session')->getCart()
            ->addProduct($data['product_id'], $data['quantity']);
        // echo '<pre>';
        // print_r($obj);
        // echo '</pre>';

        // $session = Mage::getModel('core/session');
        // $product = $request->getParam('cart');
        // if ($session->get('product') == null) {
        // } else {
        //     $arr = $session->get('product');
        // }
        // if (array_key_exists($product['product_id'], $arr)) {
        //     $arr[$product['product_id']] = $arr[$product['product_id']] + $product['quantity'];
        // } else {
        //     $arr[$product['product_id']] = $product['quantity'];
        // }
        // $session->set('cart', $arr);
    }
    public function testAction()
    {
        // echo "123";
        $collection = Mage::getModel('checkout/cart')->getCollection();
        // $collection2 = Mage::getModel('checkout/cart_item')->getCollection();
        echo '<pre>';
        print_r($collection);
        // print_r($collection2);
        echo '</pre>';
    }
}