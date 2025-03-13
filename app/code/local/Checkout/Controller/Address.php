<?php
class Checkout_Controller_Address extends Core_Controller_Front_Action
{
    public function indexAction()
    {
        $layout = Mage::getBlock('core/layout');
        $index = $layout->createBlock('checkout/address_index')
            ->setTemplate('checkout/address/index.phtml');
        $layout->getChild('content')->addChild('index', $index);
        $layout->toHtml();
    }

    public function saveAddressAction()
    {
        $data = $this->getRequest()->getParams();

        $cart = Mage::getSingleton('checkout/session')
            ->getCart();
        $cart->setEmail($data['billing']['email'])
            ->save();
        if ($data['billing']) {
            $address = Mage::getModel('checkout/cart_address');
            $address->setCartId($cart->getCartId());
            $address->setAddressType("billing");
            foreach ($data['billing'] as $field => $value) {
                $setfield = sprintf("set%s", ucfirst($field));
                $address->$setfield($value);
            }
            $address->save();
        }
        if (!isset($data['shipping'])) {
            $data['shipping'] = $data['billing'];
        }
        if ($data['shipping']) {
            $address = Mage::getModel('checkout/cart_address');
            $address->setCartId($cart->getCartId());
            $address->setAddressType("shipping");
            foreach ($data['shipping'] as $field => $value) {
                $setfield = sprintf("set%s", ucfirst($field));
                $address->$setfield($value);
            }
            $address->save();
        }
        $this->redirect('checkout/address/index');
    }
}
