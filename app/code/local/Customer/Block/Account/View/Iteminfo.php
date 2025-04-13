<?php
class  Customer_Block_Account_View_Iteminfo extends Core_Block_Template
{
    protected $_collection;

    public function __construct()
    {
        $this->_template = 'customer/account/view/iteminfo.phtml';
        $toolbar = $this->getLayout()->createBlock('customer/grid_toolbar');
        $this->addChild('toolbar', $toolbar);
        $this->getLayout()->getChild('content')->getChild('view')->addChild('iteminfo', $this);
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