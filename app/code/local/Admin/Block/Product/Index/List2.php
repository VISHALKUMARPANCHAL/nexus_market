<?php

class Admin_Block_Product_Index_List extends Admin_Block_Widget_Grid
{
    public function __construct()
    {
        $this->addColumn(
            "product_id",
            [
                "render" => "text",
                "filter" => "number",
                "data_index" => "product_id",
                "lable" => "Product Id"
            ]
        );
        $this->addColumn(
            "name",
            [
                "render" => "text",
                "filter" => "text",
                "data_index" => "name",
                "lable" => "Name"
            ]
        );
        $this->addColumn(
            "description",
            [
                "render" => "text",
                "filter" => "text",
                "data_index" => "description",
                "lable" => "Description"
            ]
        );
        $this->addColumn(
            "sku",
            [
                "render" => "text",
                "filter" => "text",
                "data_index" => "sku",
                "lable" => "SKU"
            ]
        );
        $this->addColumn(
            "price",
            [
                "render" => "text",
                "filter" => "number",
                "data_index" => "price",
                "lable" => "Price"
            ]
        );
        $this->addColumn(
            "stock_quantity",
            [
                "render" => "text",
                "filter" => "number",
                "data_index" => "stock_quantity",
                "lable" => "Stock Quantity"
            ]
        );
        $this->addColumn(
            "category_id",
            [
                "render" => "text",
                "filter" => "number",
                "data_index" => "category_id",
                "lable" => "Category Id"
            ]
        );
        $this->addColumn(
            "series",
            [
                "render" => "text",
                "filter" => "text",
                "data_index" => "series",
                "lable" => "Series"
            ]
        );
        $this->addColumn(
            "material",
            [
                "render" => "text",
                "filter" => "text",
                "data_index" => "material",
                "lable" => "Material"
            ]
        );
        $this->addColumn(
            "weight",
            [
                "render" => "text",
                "filter" => "number",
                "data_index" => "weight",
                "lable" => "Weight"
            ]
        );
        $this->addColumn(
            "delete",
            [
                "render" => "link",
                "callback" => "getDeleteUrl",
                "lable" => "Delete"
            ]
        );
        $this->addColumn(
            "update",
            [
                "render" => "link",
                "callback" => "getEditUrl",
                "lable" => "Update"
            ]
        );

        $product = Mage::getModel('catalog/product')
            ->getCollection()->addAttributeToSelect(["series", "material", "weight"]);
        $this->setCollection($product);
        Parent::__construct();
    }

    public function getEditUrl($data)
    {
        return $this->getUrl("*/*/new?id=$data->product_id");
    }
    public function getDeleteUrl($data)
    {
        return $this->getUrl("*/*/delete?id=$data->product_id");
    }
}