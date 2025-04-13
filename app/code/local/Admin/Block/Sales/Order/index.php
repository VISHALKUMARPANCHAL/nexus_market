<?php
class Admin_Block_Sales_Order_Index extends Admin_Block_Widget_Grid
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
            ->getCollection();
        $this->getChild('toolbar')->prepareToolbar();
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    public function getOrderData()
    {
        return $this->getCollection()
            ->orderBy(["created_at DESC"])
            ->getData();
    }
}