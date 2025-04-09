<?php
class Practice_Model_Resource_Crud extends Core_Model_Resource_Abstract
{
    public function __construct()
    {
        $this->init('practice_crud', 'cid');
    }
}