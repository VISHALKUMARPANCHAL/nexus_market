<?php

class Admin_Block_Category_Index_List extends Core_Block_Template
{
    public function getData()
    {
        $product = Mage::getModel('catalog/category')
            ->getCollection();
        $data = $product->getData();
        return $data;
    }
    public function getParentName($cid)
    {
        return Mage::getSingleton('catalog/category')
            ->load($cid)->getName();
    }
}
