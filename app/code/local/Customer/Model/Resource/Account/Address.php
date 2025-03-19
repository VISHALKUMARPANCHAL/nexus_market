<?php
class Customer_Model_Resource_Account_Address extends Core_Model_Resource_Abstract
{
    public function __construct()
    {
        $this->init('Customer_Account_Address', 'address_id');
    }
}