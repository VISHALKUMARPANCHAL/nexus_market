<?php

class Admin_Block_Category_Index_List extends Core_Block_Template
{
    protected $_collection;

    public function __construct()
    {
        $this->setTemplate('admin/category/index/new.phtml');
        $toolbar = $this->getLayout()->createBlock('admin/grid_toolbar');
        $csv = $this->getLayout()->createBlock('admin/export_csv');
        $this->addChild('toolbar', $toolbar);
        $this->addChild('csv', $csv);
        $this->init();
    }
    public function init()
    {
        $this->_collection = Mage::getModel('catalog/category')
            ->getCollection();
        $this->getChild('toolbar')->prepareToolbar();
        $this->getChild('csv')->prepareCsv();
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