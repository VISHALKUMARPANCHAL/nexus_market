<?php
class Admin_Block_Ticket_Index_List extends Admin_Block_Widget_Grid
{
    public function __construct()
    {
        $this->addColumn(
            "ticket_id",
            [
                "render" => "text",
                "filter" => "number",
                "data_index" => "ticket_id",
                "lable" => "Ticket Id"
            ]
        );
        $this->addColumn(
            "title",
            [
                "render" => "text",
                "filter" => "text",
                "data_index" => "title",
                "lable" => "Title"
            ]
        );
        $this->addColumn(
            "created_at",
            [
                "render" => "text",
                "filter" => "text",
                "data_index" => "created_at",
                "lable" => "Created At"
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
        $this->addColumn(
            "view",
            [
                "render" => "link",
                "callback" => "view",
                "lable" => "View"
            ]
        );
        $tickets = Mage::getModel('ticket/ticket')
            ->getCollection();
        $this->setCollection($tickets);
        Parent::__construct();
    }
    public function getEditUrl($data)
    {
        return $this->getUrl("*/*/new?id=$data->ticket_id");
    }
    public function getDeleteUrl($data)
    {
        return $this->getUrl("*/*/delete?id=$data->ticket_id");
    }
    public function view($data)
    {
        return $this->getUrl("*/*/view?id=$data->ticket_id");
    }
}