<?php
class Cms_Block_Index extends Core_Block_Template
{
    public function getImages()
    {
        $product = Mage::getModel('catalog/product')
            ->getCollection()
            ->leftJoin(['catalog_media_gallery' => 'catalog_media_gallery'], 'main_table.product_id=catalog_media_gallery.product_id', ["file_path" => 'file_path', 'main_image' => 'main_image'])
            ->addFieldToFilter('main_image', 1);
        return $product->getData();
    }
}
