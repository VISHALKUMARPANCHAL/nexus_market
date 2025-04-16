<?php
class Admin_Controller_Ticket_Index extends Core_Controller_Admin_Action
{
    public function listAction()
    {
        $list = $this->getLayout()->createBlock('admin/ticket_index_list');
        $this->getLayout()->getChild('content')->addChild('list', $list);
        $this->getLayout()->toHtml();
    }
    public function newAction()
    {
        $new = $this->getLayout()->createBlock('admin/ticket_index_new');
        $this->getLayout()->getChild('content')->addChild('new', $new);
        $this->getLayout()->toHtml();
    }
    public function saveAction()
    {
        $data = $this->getRequest()->getParam('ticket');
        Mage::getModel('ticket/ticket')
            ->setData($data)
            ->save();
        $this->redirect('admin/ticket_index/list');
    }
    public function savecommentAction()
    {
        $data = $this->getRequest()->getParams();
        Mage::log($data);
        if ($data['parent_id'] == 0) {
            unset($data['parent_id']);
        }
        Mage::getModel('ticket/comment')
            ->setData($data)
            ->save();
    }
    public function updateAction()
    {
        $data = $this->getRequest()->getParams();
        Mage::log($data);
        // die;
        Mage::getModel('ticket/comment')
            ->setData($data)
            ->setIsActive(0)
            ->save();
    }
    public function viewAction()
    {
        $id = $this->getRequest()->getQuery('id');
        $view = $this->getLayout()->createBlock('admin/ticket_index_view');
        $this->getLayout()->getChild('content')->addChild('view', $view);
        $this->getLayout()->getChild('head')->addJs('page/admin/ticket/index/view.js');
        $this->getLayout()->getChild('head')->addCss('page/admin/ticket/index/view.css');
        $this->getLayout()->toHtml();
    }
    public function deleteAction()
    {
        $id = $this->getRequest()->getQuery('id');
        Mage::getModel('ticket/ticket')
            ->setTicketId($id)
            ->delete();
        $this->redirect('admin/ticket_index/list');
    }
}
