<?php
class Customer_Block_Account_Orders extends Core_Block_Template
{
    public function __construct()
    {
        $this->_template = "customer/account/orders.phtml";
    }
    public function getAllOrders()
    {
        return Mage::getModel('sales/order')
            ->getCollection()
            ->addFieldToFilter('customer_id', $this->getCustomerId())
            ->orderBy(["created_at DESC"])
            ->getData();
    }
    public function getCustomerId()
    {
        return Mage::getSingleton('core/session')
            ->get('customer_id');
    }
}