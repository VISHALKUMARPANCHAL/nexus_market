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
        $customer_address = Mage::getModel('customer/account_address')
            ->getCollection()
            ->addFieldToFilter('customer_id', $this->getCustomerId())
            ->getData();
        if (empty($customer_address)) {
            Mage::getModel('customer/account_address')
                ->setData($this->getData())
                ->setIsDefault(1)
                ->save();
        }
    }
}