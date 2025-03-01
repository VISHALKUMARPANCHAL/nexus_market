<?php
class Catalog_Block_Product_List extends Core_Block_Template
{

    public function __construct()
    {
        $this->setTemplate('catalog/product/list.phtml');
    }
    public function getProducts()
    {
        $product = Mage::getModel('catalog/product')
            ->getCollection()->leftJoin(['catalog_media_gallery' => 'catalog_media_gallery'], 'main_table.product_id=catalog_media_gallery.product_id', ["file_path" => 'file_path'])
            ->groupBy(['main_table.product_id']);
        return $product->getData();
    }
}
