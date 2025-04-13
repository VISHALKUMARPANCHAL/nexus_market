<?php
class  Customer_Block_Account_View_Orderinfo extends Core_Block_Template
{
    public function __construct()
    {
        $this->_template = 'customer/account/view/orderinfo.phtml';
    }

    public function getOrdeInfo()
    {
        return $this->getParent()->getOrder();
    }
}