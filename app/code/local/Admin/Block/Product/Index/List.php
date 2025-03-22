<?php

class Admin_Block_Product_Index_List extends Core_Block_Template
{
    protected $_collection;
    public function __construct()
    {
        $toolbar = $this->getLayout()->createBlock('admin/grid_toolbar');
        $this->addChild('toolbar', $toolbar);
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
        $this->_collection = Mage::getModel('catalog/product')
            ->getcollection();
        $this->getChild('toolbar')->prepareToolbar();
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