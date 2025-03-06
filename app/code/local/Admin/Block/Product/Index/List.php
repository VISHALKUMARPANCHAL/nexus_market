<?php

class Admin_Block_Product_Index_List extends Core_Block_Template
{

    public function getData()
    {
        $product = Mage::getSingleton('catalog/product')
            ->getcollection()
            ->addAttributeToSelect(["series", "material", "weight"]);
        return $product->getData();
    }
    public function getCategoryName($cid)
    {
        return Mage::getSingleton('catalog/category')
            ->load($cid)->getName();
    }
}