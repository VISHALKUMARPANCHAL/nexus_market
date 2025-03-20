<?php
class Customer_Block_Account_Address_Index extends Core_Block_Template
{
    public function __construct()
    {
        $this->_template = "customer/account/address/index.phtml";
    }
    public function getAddressId()
    {
        return  Mage::getModel('core/request')->getQuery('id');
    }
    public function getAddress()
    {
        return Mage::getModel('customer/account_address')
            ->load($this->getAddressId());
    }
}