<?php

class Admin_Block_Category_Index_New extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate("admin/category/index/new.phtml");
    }
    public function getCategory()
    {
        $request = Mage::getModel('core/request');
        $id = $request::getQuery('id');
        $data = Mage::getModel('catalog/category')
            ->load($id);
        return $data;
    }
    public function availableCatagories()
    {
        $product = Mage::getModel('catalog/category')
            ->getCollection();
        $data = $product->getData();
        return $data;
    }
    public function getId()
    {
        return Mage::getModel('core/request')->getQuery('id');
    }
}