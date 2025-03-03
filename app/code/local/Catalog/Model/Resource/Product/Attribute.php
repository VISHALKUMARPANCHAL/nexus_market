<?php
class Catalog_Model_Resource_Product_Attribute extends Core_Model_Resource_Abstract
{
    public function __construct()
    {
        $this->init('catalog_product_attribute', 'value_id');
    }
}