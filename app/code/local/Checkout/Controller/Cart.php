<?php
class Checkout_Controller_Cart extends Core_Controller_Customer_Action
{
    public function indexAction()
    {
        $layout = Mage::getBlock('core/layout');
        $index = $layout->createBlock('checkout/cart_index');
        $layout->getChild('content')->addChild('index', $index);
        $layout->getChild('head')->addJs("page/checkout/cart.js");

        $layout->toHtml();
    }
    public function addAction()
    {
        $data = $this->getRequest()->getParams();
        Mage::getSingleton('checkout/session')->getCart()
            ->addProduct($data['product_id'], $data['quantity'])
            ->save();
        $this->getRequest()
            ->getMessageModel()
            ->addMessage('success', "Product added to your cart!");
        // Mage::log($_SESSION);
        $this->redirect('checkout/cart/index');
    }

    public function removeAction()
    {
        $id = $this->getRequest()->getQuery('id');
        // Mage::log($id);
        // die;
        Mage::getSingleton('checkout/session')
            ->getCart()
            ->removeItem($id)
            ->save();
        $this->redirect('checkout/cart/index');
    }
    public function updateAction()
    {
        $productData = $this->getRequest()->getParams();
        // Mage::log($productData);
        // die;
        Mage::getSingleton('checkout/session')
            ->getCart()
            ->updateItem($productData['item_id'], $productData['quantity'])
            ->save();
        $this->redirect('checkout/cart/index');
    }
    public function applyCouponAction()
    {
        $data = $this->getRequest()->getParams();
        // Mage::log($data);
        // die;
        $cart = Mage::getSingleton('checkout/session')
            ->getCart();
        $discount = Mage::getModel('checkout/coupon')
            ->calculateDiscount($data['coupon_code'], $data['sub_total']);
        if ($discount === 0 || $data['type'] === "Remove") {
            $cart->setCouponCode("");
            $cart->setCouponDiscount(0);
        } else {
            $cart->setCouponCode($data['coupon_code']);
            $cart->setCouponDiscount($discount);
        }
        $cart->save();
        $this->redirect('checkout/cart/index');
    }
    public function testAction()
    {
        $itemCollection = Mage::getSingleton('checkout/session')
            ->getCart()
            ->getItemCollection(5);
        $itemCollection->select(['SUM(main_table.sub_total)' => 'sumoftotal', 'item_id']);
        Mage::log($itemCollection->prepareQuery());
    }
}
