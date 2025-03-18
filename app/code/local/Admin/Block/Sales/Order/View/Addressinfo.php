<?php
class  Admin_Block_Sales_Order_View_Addressinfo extends Core_Block_Template
{
    protected $_orderBlock = null;

    public function __construct()
    {
        $this->_template = 'Admin/sales/order/view/addressinfo.phtml';
    }
    public function setOrderBlock($block)
    {
        $this->_orderBlock = $block;
        return $this;
    }

    public function getBillingAddress()
    {
        return $this->_orderBlock->getOrder()->getBillingAddress();
    }
    public function getShippingAddress()
    {
        return $this->_orderBlock->getOrder()->getShippingAddress();
    }
}
