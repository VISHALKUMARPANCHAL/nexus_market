<?php

class Admin_Block_Category_Index_List extends Admin_Block_Widget_Grid
{
    public function __construct()
    {
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
            "parent_id",
            [
                "render" => "text",
                "filter" => "text",
                "data_index" => "parent_id",
                "lable" => "Parent Id"
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
        $get = $this->getRequest()->getQuery();
        $category = Mage::getModel('catalog/category')
            ->getCollection();
        if (!empty($get['category_id-to']) && $get['category_id-from']) {
            $category->addFieldToFilter('category_id', ['BETWEEN' => [$get['category_id-from'], $get['category_id-to']]]);
        }
        if (!empty($get['category_id-to'])) {
            $category->addFieldToFilter('category_id', ['BETWEEN' => [$get['category_id-from'], $get['category_id-to']]]);
        }
        if (!empty($get['name'])) {
            $category->addFieldToFilter('name', ['LIKE' => "%{$get['name']}%"]);
        }
        if (!empty($get['description'])) {
            $category->addFieldToFilter('description', ['LIKE' => "%{$get['description']}%"]);
        }
        if (!empty($get['parent_id'])) {
            $category->addFieldToFilter('parent_id', ['LIKE' => "%{$get['parent_id']}%"]);
        }
        $this->setCollection($category);
        Parent::__construct();
    }
    public function getEditUrl($data)
    {
        return $this->getUrl("*/*/new?id=$data->category_id");
    }
    public function getDeleteUrl($data)
    {
        return $this->getUrl("*/*/delete?id=$data->category_id");
    }
}
