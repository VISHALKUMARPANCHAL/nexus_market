<?php
class Admin_Block_Sales_Order_Index extends Core_Block_Template
{
    public function __construct()
    {
        $this->_template = "admin/sales/order/index.phtml";
    }
    public function getOrderData()
    {
        $orderData = Mage::getModel('sales/order')
            ->getCollection()
            ->getData();
        return $orderData;
    }
}