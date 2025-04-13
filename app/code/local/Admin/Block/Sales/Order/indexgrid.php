<?php
class Admin_Block_Sales_Order_Index extends Admin_Block_Widget_Grid
{
    public function __construct()
    {
        $this->addColumn(
            "order_id",
            [
                "render" => "text",
                "filter" => "number",
                "data_index" => "order_id",
                "lable" => "Order Id"
            ]
        );
        $this->addColumn(
            "customer_id",
            [
                "render" => "text",
                "filter" => "number",
                "data_index" => "customer_id",
                "lable" => "Customer Id"
            ]
        );
        $this->addColumn(
            "email",
            [
                "render" => "text",
                "filter" => "text",
                "data_index" => "email",
                "lable" => "Email"
            ]
        );
        $this->addColumn(
            "total_amount",
            [
                "render" => "text",
                "filter" => "number",
                "data_index" => "total_amount",
                "lable" => "Total Amount"
            ]
        );
        $this->addColumn(
            "payment_method",
            [
                "render" => "text",
                "filter" => "text",
                "data_index" => "payment_method",
                "lable" => "Payment Method"
            ]
        );
        $this->addColumn(
            "order_status",
            [
                "render" => "dropdown",
                "filter" => "dropdown",
                "data_index" => "order_status",
                "lable" => "Status",
                "options" => ["Pending", "Processing", "Shipped", "Delevered", "Cancelled"]
            ]
        );
        $this->addColumn(
            "view",
            [
                "render" => "link",
                "callback" => "getViewUrl",
                "lable" => "View"
            ]
        );

        $product = Mage::getModel('sales/order')
            ->getCollection();
        $this->setCollection($product);
        Parent::__construct();
    }

    public function getViewUrl($data)
    {
        return $this->getUrl("*/*/view?id=$data->order_id");
    }
}