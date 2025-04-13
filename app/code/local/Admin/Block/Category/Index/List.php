<?php

class Admin_Block_Category_Index_List extends Core_Block_Template
{
    protected $_collection;

    public function __construct()
    {
        $this->setTemplate('admin/category/index/list.phtml');
        $toolbar = $this->getLayout()->createBlock('admin/grid_toolbar');
        $this->addChild('toolbar', $toolbar);
        $this->init();
    }
    public function init()
    {
        $this->_collection = Mage::getModel('catalog/category')
            ->getCollection();
        $this->getChild('toolbar')->prepareToolbar();
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    public function getData()
    {
        $category = $this->getCollection()->getData();
        return $category;
    }
    public function getParentName($pid)
    {
        return Mage::getModel('catalog/category')
            ->load($pid)->getName();
    }
}