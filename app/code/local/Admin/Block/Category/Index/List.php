<?php

class Admin_Block_Category_Index_List extends Core_Block_Template
{
    protected $_collection;

    public function __construct()
    {
        $this->setTemplate('admin/category/index/new.phtml');
        $toolbar = $this->getLayout()->createBlock('admin/grid_toolbar');
        $this->addChild('toolbar', $toolbar);
        $this->init();
    }
    public function init()
    {
        $this->_collection = Mage::getModel('catalog/category')
            ->getcollection();
        $this->getChild('toolbar')->prepareToolbar();
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    public function getData()
    {
        $data = $this->getCollection()->getData();
        return $data;
    }
    public function getParentName($cid)
    {
        return Mage::getSingleton('catalog/category')
            ->load($cid)->getName();
    }
}