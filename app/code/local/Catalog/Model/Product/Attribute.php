<?php
class Catalog_Model_Product_Attribute extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = 'Catalog_Model_Product_Resource_Attribute';
        $this->_collectionClass = 'Catalog_Model_Product_Resource_Attribute_Collection';
    }
}