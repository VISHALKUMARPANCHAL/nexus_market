<?php
class Admin_Block_Sales_Order_Index extends Core_Block_Template
{
    protected $_collection;

    public function __construct()
    {
        $this->_template = "admin/sales/order/index.phtml";
        $toolbar = $this->getLayout()->createBlock('admin/grid_toolbar');
        $this->addChild('toolbar', $toolbar);
        $this->init();
    }
    public function init()
    {
        $this->_collection = Mage::getModel('sales/order')
            ->getcollection();
        $this->getChild('toolbar')->prepareToolbar();
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    public function getOrderData()
    {
        $orderData = $this->getCollection()
            ->getData();
        return $orderData;
    }
}