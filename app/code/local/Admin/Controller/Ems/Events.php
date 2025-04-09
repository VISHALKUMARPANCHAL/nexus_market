<?php
class Admin_Controller_Ems_Events extends Core_Controller_Admin_Action
{
    public function addAction()
    {
        $add = $this->getLayout()->createBlock('admin/Ems_Events_Add');
        $this->getLayout()->getChild('content')->addChild('add', $add);
        $this->getLayout()->toHtml();
    }
    public function deleteAction()
    {
        $id = $this->getRequest()->getQuery('id');
        $events = Mage::getModel('ems/events')
            ->setEventId($id)
            ->delete();
    }
    public function listAction()
    {
        $list = $this->getLayout()->createBlock('admin/Ems_Events_List');
        $this->getLayout()->getChild('content')->addChild('list', $list);
        $this->getLayout()->toHtml();
    }
    public function eventUsersAction()
    {
        $eventUsers = $this->getLayout()->createBlock('admin/Ems_Events_eventUsers');
        $this->getLayout()->getChild('content')->addChild('eventUsers', $eventUsers);
        $this->getLayout()->getChild('head')->addJs("page/ems/events/eventuser.js");
        $this->getLayout()->toHtml();
    }
    public function addPostAction()
    {
        $data = $this->getRequest()->getParam('events');
        Mage::log($data);
        $events = Mage::getModel('ems/events')
            ->setdata($data);
        $admin_id = $this->getSession()->get('admin_id');
        $events->setCreatedBy($admin_id);
        Mage::log($admin_id);
        $events->save();
        $this->redirect('admin/ems_events/list');
    }
    public function changestatusAction()
    {
        $id = $this->getRequest()->getParam('id');
        $uid = $this->getRequest()->getParam('userid');
        $status = $this->getRequest()->getParam('status');
        // Mage::log($uid);

        $rid = Mage::getModel('ems/registrations')
            ->getCollection()
            ->addFieldToFilter('event_id', $id)
            ->addFieldToFilter('user_id', $uid)
            ->getFirstItem()
            ->getRegistrationId();
        $a = Mage::getModel('ems/registrations')
            ->setRegistrationId($rid)
            ->setStatus($status)
            ->save();
        $this->redirect("admin/ems_events/eventUsers?id={$id}");
    }
}