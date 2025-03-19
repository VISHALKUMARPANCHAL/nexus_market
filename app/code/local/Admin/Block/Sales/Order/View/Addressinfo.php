<?php
class  Admin_Block_Sales_Order_View_Addressinfo extends Core_Block_Template
{

    public function __construct()
    {
        $this->_template = 'Admin/sales/order/view/addressinfo.phtml';
    }
    public function getBillingAddress()
    {
        return $this->getParent()->getOrder()->getBillingAddress();
    }
    public function getShippingAddress()
    {
        return $this->getParent()->getOrder()->getShippingAddress();
    }
}