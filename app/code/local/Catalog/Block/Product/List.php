<?php
class Catalog_Block_Product_List extends Core_Block_Template
{

    public function __construct()
    {
        $filter = $this->getLayout()->createBlock('catalog/product_list_filter');
        $products = $this->getLayout()->createBlock('catalog/product_list_products');
        $this->addChild("filter", $filter);
        $this->addChild("products", $products);
    }
    public function getProducts()
    {
        $products = Mage::getModel('catalog/filter')->getProductCollection()->getData();
        return $products;
    }
    public function getImagePath($pid)
    {
        $product = Mage::getModel('catalog/product')->load($pid);
        $key = array_search(1, $product->getMainImage());
        if ($key != "") {
            return $product->getFilePath()[$key];
        } else {
            return isset($product->getFilePath()[0]) ? $product->getFilePath()[0] : "";
        }
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
        $data = Mage::getModel('catalog/product_attribute')
            ->getcollection()
            ->addFieldToFilter('attribute_id', $attrId)
            ->getData();
        return $this->uniquevalues($data);
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