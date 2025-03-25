<?php
class Catalog_Block_Product_List_Products extends Catalog_Block_Product_List
{
    protected $_collection;

    public function __construct()
    {
        $this->setTemplate('catalog/product/list/products.phtml');
        $toolbar = $this->getLayout()->createBlock('customer/grid_toolbar');
        $this->addChild('toolbar', $toolbar);
        $this->init();
    }
    public function init()
    {
        $this->_collection = Mage::getModel('catalog/filter')
            ->getProductCollection();
        $this->getChild('toolbar')->prepareToolbar();
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    public function getCaegoryName($cid)
    {
        $cname = Mage::getModel('catalog/category')
            ->getCollection()
            ->addFieldToFilter('category_id', $cid)
            ->getFirstItem()
            ->getName();
        return $cname;
    }
    public function getProducts()
    {
        $products = $this->getCollection()
            ->getData();
        return $products;
    }
}