<?php
class practice_Block_Crud_Index extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('practice/crud/index.phtml');
    }
    public function getData()
    {
        return Mage::getModel('practice/crud')
            ->getCollection()
            ->getData();
    }
}