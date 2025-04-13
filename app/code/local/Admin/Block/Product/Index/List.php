<?php

class Admin_Block_Product_Index_List extends Core_Block_Template
{

    protected $_collection;

    public function __construct()
    {
        $this->setTemplate('admin/product/index/list.phtml');
        $toolbar = $this->getLayout()->createBlock('admin/grid_toolbar');
        $this->addChild('toolbar', $toolbar);
        $this->init();
    }
    public function init()
    {
        $this->_collection = Mage::getModel('catalog/product')
            ->getCollection()->addAttributeToSelect(["series", "material", "weight"]);
        $this->getChild('toolbar')->prepareToolbar();
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    public function getData()
    {
        $product = $this->getCollection()->getData();
        return $product;
    }
    public function getCategoryName($cid)
    {
        return Mage::getModel('catalog/category')
            ->load($cid)
            ->getName();
    }
}