<?php
class Sales_Model_Order extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = 'Sales_Model_Resource_Order';
        $this->_collectionClass = 'Sales_Model_Resource_Order_Collection';
    }
}