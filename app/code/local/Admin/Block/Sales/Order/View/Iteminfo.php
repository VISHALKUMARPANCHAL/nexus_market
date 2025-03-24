<?php
class  Admin_Block_Sales_Order_View_Iteminfo extends Core_Block_Template
{
    protected $_collection;

    public function __construct()
    {
        $this->_template = 'Admin/sales/order/view/iteminfo.phtml';
        $toolbar = $this->getLayout()->createBlock('admin/grid_toolbar');
        $this->addChild('toolbar', $toolbar);
        $this->getAdminLayout()->getChild('content')->getChild('view')->addChild('iteminfo', $this);
        $this->init();
    }

    public function init()
    {
        $this->_collection = $this->getParent()->getOrder()->getItemCollection();
        $this->getChild('toolbar')->prepareToolbar();
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    public function getItems()
    {
        return $this->getCollection()->getData();
    }
}