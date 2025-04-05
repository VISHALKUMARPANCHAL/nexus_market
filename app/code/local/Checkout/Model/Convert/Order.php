<?php
class Checkout_Model_Convert_Order
{
    public function convert($cart)
    {
        $cartData = $cart->getData();
        unset($cartData['cart_id']);
        unset($cartData['created_at']);
        unset($cartData['updated_at']);
        $order = Mage::getModel('sales/order')
            ->setData($cartData)
            ->save();
        $orderId = $order->getOrderId();
        $orderItem = Mage::getModel('sales/order_item');
        $cartItems = $cart
            ->getItemCollection()
            ->getData();
        foreach ($cartItems as $cartItem) {
            $cartItemData = $cartItem->getData();
            unset($cartItemData['item_id']);
            $orderItem->setData($cartItemData);
            $orderItem->setOrderId($orderId)->save();
        }

        $billingAddress = $cart
            ->getBillingAddress()
            ->getFirstItem()
            ->getData();
        $orderAddress = Mage::getModel('sales/order_address');
        unset($billingAddress['address_id']);
        unset($billingAddress['cart_id']);
        unset($billingAddress['created_at']);
        unset($billingAddress['updated_at']);
        $orderAddress->setData($billingAddress);
        $orderAddress->setOrderId($orderId)->save();

        $shippingAddress = $cart
            ->getShippingAddress()
            ->getFirstItem()
            ->getData();
        $orderAddress2 = Mage::getModel('sales/order_address');
        unset($shippingAddress['address_id']);
        unset($shippingAddress['cart_id']);
        unset($shippingAddress['created_at']);
        unset($shippingAddress['updated_at']);
        $orderAddress2->setData($shippingAddress);
        $orderAddress2->setOrderId($orderId)->save();
        return $order;
    }
}