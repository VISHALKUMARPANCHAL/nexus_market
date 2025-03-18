<?php
class  Admin_Block_Sales_Order_View_Orderinfo extends Core_Block_Template
{
    protected $_orderBlock = null;
    public function __construct()
    {
        $this->_template = 'Admin/sales/order/view/orderinfo.phtml';
    }
    public function setOrderBlock($block)
    {
        $this->_orderBlock = $block;
        return $this;
    }
    public function getOrdeInfo()
    {
        return $this->_orderBlock->getOrder();
    }
}
