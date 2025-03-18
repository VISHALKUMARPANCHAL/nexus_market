<?php
class Sales_Model_Order extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = 'Sales_Model_Resource_Order';
        $this->_collectionClass = 'Sales_Model_Resource_Order_Collection';
    }
    public function getItemCollection()
    {
        return Mage::getModel('sales/order_item')->getCollection()
            ->addFieldtoFilter('order_id', $this->getOrderId());
    }
    public function getAddressCollection()
    {
        return Mage::getModel('sales/order_address')->getCollection()
            ->addFieldtoFilter('order_id', $this->getOrderId());
    }
    public function getBillingAddress()
    {
        return $this->getAddressCollection()
            ->addFieldtoFilter('address_type', 'billing')
            ->getFirstItem();
    }
    public function getShippingAddress()
    {
        return $this->getAddressCollection()
            ->addFieldtoFilter('address_type', 'shipping')
            ->getFirstItem();
    }
}
