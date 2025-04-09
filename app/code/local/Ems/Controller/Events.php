<?php
class Ems_Controller_Events extends Core_Controller_Customer_Action
{
    public function listAction()
    {
        $list = $this->getLayout()->createBlock('Ems/Events_List');
        $this->getLayout()->getChild('content')->addChild('list', $list);
        $this->getLayout()->toHtml();
    }
    public function RegisterAction()
    {
        $id = $this->getRequest()
            ->getQuery('id');
        $event = Mage::getModel('ems/events')
            ->load($id);
        $user_id = $this->getSession()->get('customer_id');
        // Mage::log($user_id);
        // Mage::log($event);
        $current = date('y-d-m h:i:s', time());
        $register = Mage::getModel('ems/registrations')
            ->setUserId($user_id)
            ->setEventId($event->getEventId())
            ->setStatus('Pending')
            ->setUpdatedAt($current)
            ->save();
        $this->redirect('ems/events/list');
    }
}