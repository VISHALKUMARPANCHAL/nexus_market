<?php
class Page_Block_Header extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('page/header.phtml');
    }
    public function getMasterCategories()
    {
        $cat = Mage::getModel('catalog/category')
            ->getCollection();
        $categories = $cat->getData();
        return $categories;

        // $cat = Mage::getModel('catalog/category')
        //     ->getCollection()
        //     ->leftJoin('catalog_category', 'child.parent_id = parent.category_id', ['parent_id' => 'parent.category_id', 'parent_name' => 'parent.name', 'child_id' => 'child.category_id', 'child_name' => 'child.name']);
        // $categories = $cat->getData();
        // return $categories;
    }
    public function countCartItems()
    {
        $cartItems = Mage::getSingleton('checkout/session')
            ->getCart()
            ->getItemCollection()
            ->getData();
        return count($cartItems);
    }
}