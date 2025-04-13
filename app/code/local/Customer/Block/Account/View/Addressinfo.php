<?php
class  Customer_Block_Account_View_Addressinfo extends Core_Block_Template
{

    public function __construct()
    {
        $this->_template = 'customer/account/view/addressinfo.phtml';
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