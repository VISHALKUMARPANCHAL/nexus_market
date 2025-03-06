<?php
class Catalog_Block_Product_List_Products extends Catalog_Block_Product_List
{
    public function __construct()
    {
        $this->setTemplate('catalog/product/list/products.phtml');
    }
}