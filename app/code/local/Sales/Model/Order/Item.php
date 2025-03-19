<?php
class Sales_Model_Order_Item extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = 'Sales_Model_Resource_Order_Item';
        $this->_collectionClass = 'Sales_Model_Resource_Order_Item_Collection';
    }
    public function getProduct()
    {
        return Mage::getModel('catalog/product')->load($this->getProductId());
    }
}