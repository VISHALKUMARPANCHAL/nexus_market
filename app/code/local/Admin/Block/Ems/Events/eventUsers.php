<?php
class Admin_Block_Ems_Events_eventUsers extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate("admin/ems/events/eventUsers.phtml");
    }
    public function getRegisteredUser()
    {
        $id = $this->getRequest()->getQuery('id');
        $registration = Mage::getModel('ems/registrations')
            ->getCollection()
            ->addFieldToFilter('event_id', $id)
            ->getData();
        $users = [];
        foreach ($registration as $i) {
            $data = Mage::getModel('customer/account')
                ->load($i->getUserId());
            array_push($users, $data);
        }
        return $users;
    }
    public function getEventName()
    {
        $id = $this->getRequest()->getQuery('id');
        return Mage::getModel('ems/events')->load($id)->getTitle();
    }
    public function getSummary()
    {
        $id = $this->getRequest()->getQuery('id');
        $t = Mage::getModel('ems/registrations')
            ->getCollection()
            ->addFieldToFilter('event_id', $id);
        $summary['total'] = count($t->getData());
        $p = Mage::getModel('ems/registrations')
            ->getCollection()
            ->addFieldToFilter('event_id', $id)
            ->addFieldToFilter('status', 'pending');
        $a = Mage::getModel('ems/registrations')
            ->getCollection()
            ->addFieldToFilter('event_id', $id)
            ->addFieldToFilter('status', 'approved');
        $r = Mage::getModel('ems/registrations')
            ->getCollection()
            ->addFieldToFilter('event_id', $id)
            ->addFieldToFilter('status', 'rejected');
        $summary['pending'] = count($p->getData());
        $summary['approved'] = count($a->getData());
        $summary['rejected'] = count($r->getData());
        return $summary;
    }
}
