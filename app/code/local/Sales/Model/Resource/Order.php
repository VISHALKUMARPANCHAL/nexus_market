<?php
class Sales_Model_Resource_Order extends Core_Model_Resource_Abstract
{
    public function __construct()
    {
        $this->init('order', 'order_id');
    }
}