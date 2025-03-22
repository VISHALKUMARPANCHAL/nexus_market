<?php
class Customer_Block_Account_Dashboard extends Core_Block_Template
{
    protected $_dashboard = null;
    public function __construct()
    {
        $this->_template = "customer/account/dashboard.phtml";
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
    public function getCustomerAddress()
    {
        return Mage::getModel('customer/account_address')
            ->getCollection()
            ->addFieldToFilter('customer_id', $this->getCustomerId())
            ->getData();
    }
    public function setDashboard($dashboard)
    {
        $this->_dashboard = $dashboard;
        return $this;
    }
    public function getDashboard()
    {
        if (isset($this->_dashboard)) {
            return $this->_dashboard;
        }
    }
    public function getOrders()
    {
        return Mage::getModel('sales/order')
            ->getCollection()
            ->addFieldToFilter('customer_id', $this->getCustomerId())
            ->getData();
    }
}