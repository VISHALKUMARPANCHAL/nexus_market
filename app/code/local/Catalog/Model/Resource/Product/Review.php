<?php
class Catalog_Model_Resource_Product_Review extends Core_Model_Resource_Abstract
{
    public function __construct()
    {
        $this->init('catalog_product_review', 'review_id');
    }
}
