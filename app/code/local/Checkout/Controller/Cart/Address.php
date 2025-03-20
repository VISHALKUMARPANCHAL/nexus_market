<?php
class Checkout_Controller_Cart_Address extends Core_Controller_Customer_Action
{
    public function indexAction()
    {
        $layout = Mage::getBlock('core/layout');
        $index = $layout->createBlock('checkout/cart_address_index')
            ->setTemplate('checkout/cart/address/index.phtml');
        $layout->getChild('content')->addChild('index', $index);
        $layout->getChild('head')->addJs('page/checkout/cart/address/index.js');
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
            $address_id = $address->getCollection()
                ->addFieldToFilter('cart_id', $cart->getCartId())
                ->addFieldToFilter('address_type', 'billing')
                ->getFirstItem()
                ->getAddressId();
            // Mage::log($address_id);
            // die;
            if (!empty($address_id)) {
                $address->setAddressId($address_id);
            }
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
            $address_id = $address->getCollection()
                ->addFieldToFilter('cart_id', $cart->getCartId())
                ->addFieldToFilter('address_type', 'shipping')
                ->getFirstItem()
                ->getAddressId();
            // Mage::log($address_id);
            // die;
            if (!empty($address_id)) {
                $address->setAddressId($address_id);
            }
            $address->setCartId($cart->getCartId());
            $address->setAddressType("shipping");
            foreach ($data['shipping'] as $field => $value) {
                $setfield = sprintf("set%s", ucfirst($field));
                $address->$setfield($value);
            }
            $address->save();
        }
        $this->redirect('checkout/cart_shipping/index');
    }
}
