<?php
class Admin_Block_Ems_Events_List extends Core_Block_Template
{
    protected $_collection;

    public function __construct()
    {
        $this->setTemplate("admin/ems/events/list.phtml");
        $toolbar = $this->getLayout()->createBlock('admin/grid_toolbar');
        $this->addChild('toolbar', $toolbar);
        $this->init();
    }
    public function init()
    {
        $this->_collection = Mage::getModel('ems/events')
            ->getCollection();
        $this->getChild('toolbar')->prepareToolbar();
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    public function getEvents()
    {
        $events = $this->getCollection()->getData();
        return $events;
    }
}