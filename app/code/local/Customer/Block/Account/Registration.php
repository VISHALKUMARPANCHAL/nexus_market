<?php
class Customer_Block_Account_Registration extends Core_Block_Template
{
    public function __construct()
    {
        $this->_template = "customer/account/registration.phtml";
    }
    public function getCustomerId()
    {
        return Mage::getSingleton('core/session')
            ->get('customer_id');
    }
    public function getCustomer()
    {
        return Mage::getModel('customer/account')
            ->load($this->getCustomerId());
    }
}