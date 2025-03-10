<?php
class Checkout_Model_Cart_Item extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = 'Checkout_Model_Resource_Cart_Item';
        $this->_collectionClass = 'Checkout_Model_Resource_Cart_Item_Collection';
    }
}