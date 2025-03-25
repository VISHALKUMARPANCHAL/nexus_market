<?php

class Admin_Block_Product_Index_List extends Core_Block_Template
{
    protected $_collection;
    public function __construct()
    {
        $this->setTemplate('admin/product/index/list.phtml');
        $toolbar = $this->getLayout()->createBlock('admin/grid_toolbar');
        $csv = $this->getLayout()->createBlock('admin/export_csv');
        $this->addChild('toolbar', $toolbar);
        $this->addChild('csv', $csv);
        $this->init();
    }
    public function getData()
    {
        $product = $this->getCollection()
            ->addAttributeToSelect(["series", "material", "weight"]);
        return $product->getData();
    }
    public function init()
    {
        $this->_collection = $this->getHoleCollection();
        $this->getChild('toolbar')->prepareToolbar();
        $this->getChild('csv')->prepareCsv();
    }
    public function getHoleCollection()
    {
        $collection = Mage::getModel('catalog/product')
            ->getCollection();
        return $collection;
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    public function getCategoryName($cid)
    {
        return Mage::getSingleton('catalog/category')
            ->load($cid)->getName();
    }
}