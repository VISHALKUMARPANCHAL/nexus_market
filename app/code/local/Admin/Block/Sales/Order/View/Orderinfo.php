<?php
class  Admin_Block_Sales_Order_View_Orderinfo extends Core_Block_Template
{
    public function __construct()
    {
        $this->_template = 'Admin/sales/order/view/orderinfo.phtml';
    }

    public function getOrdeInfo()
    {
        return $this->getParent()->getOrder();
    }
}