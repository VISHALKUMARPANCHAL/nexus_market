<?php
class Admin_Block_Ems_Events_Add extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate("admin/ems/events/add.phtml");
    }
    public function getEvents()
    {
        $id = $this->getRequest()->getQuery('id');
        $events = Mage::getModel('ems/events')->load($id);
        return $events;
    }
}