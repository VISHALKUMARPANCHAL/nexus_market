<?php
class  Admin_Block_Sales_Order_View_Iteminfo extends Core_Block_Template
{
    protected $_orderBlock = null;

    public function __construct()
    {
        $this->_template = 'Admin/sales/order/view/iteminfo.phtml';
    }
    public function setOrderBlock($block)
    {
        $this->_orderBlock = $block;
        return $this;
    }
    public function getData()
    {
        return $this->_orderBlock->getOrder()->getItemCollection()->getData();
    }
}
