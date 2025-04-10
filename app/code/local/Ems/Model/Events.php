<?php
class Ems_Model_Events extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = 'Ems_Model_Resource_Events';
        $this->_collectionClass = 'Ems_Model_Resource_Events_Collection';
    }
    public function EventCount()
    {
        $events = Mage::getModel('ems/registrations')
            ->getCollection()
            ->addFieldToFilter('event_id', $this->getEventId())
            ->getData();
        return count($events);
    }
    public function isRegistred()
    {
        $customer_id = Mage::getModel('core/session')->get('customer_id');
        $a = Mage::getModel('ems/registrations')
            ->getCollection()
            ->addFieldToFilter('user_id', $customer_id)
            ->addFieldToFilter('event_id', $this->getEventId())
            ->getData();
        if (count($a) == 0) {
            return false;
        } else {
            return true;
        }
    }
    public function isExeed()
    {
        $a = Mage::getModel('ems/registrations')
            ->getCollection()
            ->addFieldToFilter('event_id', $this->getEventId())
            ->addFieldToFilter("status", ['NOT IN' => "Rejected"])
            ->getData();
        if (count($a) == $this->getCapacity()) {
            return true;
        } else {
            return false;
        }
    }
    public function status()
    {
        $customer_id = Mage::getModel('core/session')->get('customer_id');
        $a = Mage::getModel('ems/registrations')
            ->getCollection()
            ->addFieldToFilter('user_id', $customer_id)
            ->addFieldToFilter('event_id', $this->getEventId())
            ->getFirstItem();
        return $a->getStatus();
    }
}