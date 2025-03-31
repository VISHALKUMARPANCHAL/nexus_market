<?php

class Admin_Block_Category_Index_List extends Admin_Block_Widget_Grid
{
    protected $_collection;

    public function __construct()
    {
        $category = Mage::getModel('catalog/category')
            ->getCollection();
        $this->setCollection($category);
        $this->addColumn(
            "category_id",
            [
                "render" => "number",
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
                "render" => "number",
                "filter" => "text",
                "data_index" => "description",
                "lable" => "Description"
            ]
        );
        $this->addColumn(
            "parent_id",
            [
                "render" => "number",
                "filter" => "text",
                "data_index" => "parent_id",
                "lable" => "Parent Id"
            ]
        );
        $this->addColumn(
            "delete",
            [
                "render" => "link",
                "data_index" => "delete",
                "lable" => "Delete",
                'url' => '*/*/delete',
                'params' => ['id' => 'category_id']
            ]
        );
        $this->addColumn(
            "update",
            [
                "render" => "link",
                "data_index" => "update",
                "lable" => "Update",
                'url' => '*/*/new',
                'params' => ['id' => 'category_id']
            ]
        );

        Parent::__construct();
    }
}
