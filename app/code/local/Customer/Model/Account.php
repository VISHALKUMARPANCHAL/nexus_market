<?php
class Customer_Model_Account extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = 'Customer_Model_Resource_Account';
        $this->_collectionClass = 'Customer_Model_Resource_Account_Collection';
    }
    protected function _afterSave()
    {
        Mage::getModel('customer/account_address')
            ->setData($this->getData())
            ->save();
    }
}
