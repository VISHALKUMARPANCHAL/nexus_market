<?php
class Catalog_Block_Category_List extends Core_Block_Template
{
    public function getData()
    {
        $category = Mage::getModel('catalog/category')
            ->getCollection();
        $data = $category->getData();
        return $data;
    }
}