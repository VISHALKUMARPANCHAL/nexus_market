<?php
class Ems_Block_Events_List extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate("ems/events/list.phtml");
    }
    public function getEvents()
    {
        $events = Mage::getModel('ems/events')
            ->getCollection()
            ->addFieldToFilter('date', ['>=' => date("Y-m-d")])
            ->getData();
        return $events;
    }
    public function getPastEvents()
    {
        $userId = Mage::getSingleton('core/session')->get('customer_id');
        $events = Mage::getModel('ems/events')
            ->getCollection()
            ->innerJoin('ems_registrations', "main_table.event_id=ems_registrations.event_id", ["status" => "status"])
            ->addFieldToFilter('ems_registrations.status', ['NOT IN' => 'Rejected'])
            ->addFieldToFilter('ems_registrations.user_id', ['=' => $userId])
            ->getData();
        // $events = array_merge($eventsapproved, $eventspendinf);
        return $events;
    }
}