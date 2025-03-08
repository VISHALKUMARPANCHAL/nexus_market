<?php
class Catalog_Block_Product_List extends Core_Block_Template
{

    public function __construct()
    {
        $this->setTemplate('catalog/product/list.phtml');
        $filter = $this->getLayout()->createBlock('catalog/product_list_filter');
        $products = $this->getLayout()->createBlock('catalog/product_list_products');
        $this->addChild("filter", $filter);
        $this->addChild("products", $products);
    }
    public function getProducts()
    {
        $product = Mage::getModel('catalog/filter')->getProductCollection();

        return $product->getData();

        // $product = Mage::getModel('catalog/product')
        //     ->getCollection()->leftJoin(['catalog_media_gallery' => 'catalog_media_gallery'], 'main_table.product_id=catalog_media_gallery.product_id', ["file_path" => 'file_path'])
        //     ->groupBy(['main_table.product_id']);
        // if ($id) {
        //     $product = $product->having('category_id', $id);
        // }
        // return $product->getData();
    }
    public function getCategoryName($id)
    {
        return Mage::getSingleton('catalog/category')->load($id)->getName();
    }
    public function getAttribute()
    {
        return Mage::getModel('catalog/attribute')->getcollection()->getData();
    }
    public function getValues($attrId)
    {
        $data = Mage::getModel('catalog/product_attribute')->getcollection()
            // ->select("value")
            ->addFieldToFilter('attribute_id', $attrId)->getData();
        return $this->uniquevalues($data);
        // return $data;
    }
    public function getCategories()
    {
        $data = Mage::getModel('catalog/category')->getCollection()
            ->addFieldToFilter('parent_id', 1)
            ->getData();
        return $data;
    }
    public function uniquevalues($data)
    {
        $uniquedata = [];
        $newdata = [];
        foreach ($data as $values) {
            $uniquedata[$values->getValue()] = 0;
        }
        foreach (array_keys($uniquedata) as $i) {
            $newdata[] = $i;
        }
        return $newdata;
    }
}