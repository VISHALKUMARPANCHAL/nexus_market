<?php
class Admin_Block_Ticket_Index_New extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('admin/ticket/index/new.phtml');
    }
    public function getId()
    {
        return $this->getRequest()->getQuery('id');
    }
    public function getData()
    {
        return Mage::getModel('ticket/ticket')
            ->load($this->getId());
    }
}