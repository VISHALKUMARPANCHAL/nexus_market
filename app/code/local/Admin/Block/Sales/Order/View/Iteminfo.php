<?php
class  Admin_Block_Sales_Order_View_Iteminfo extends Core_Block_Template
{
    public function __construct()
    {
        $this->_template = 'Admin/sales/order/view/iteminfo.phtml';
    }
    public function getItems()
    {
        return $this->getParent()->getOrder()->getItemCollection()->getData();
    }
}
