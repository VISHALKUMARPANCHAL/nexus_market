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
    }
    public function countCartItems()
    {
        $cartItems = Mage::getSingleton('checkout/session')
            ->getCart()
            ->getItemCollection()
            ->getData();
        return count($cartItems);
    }
    public function isSession()
    {
        return Mage::getSingleton('core/session')
            ->get('customer_id');
    }
}