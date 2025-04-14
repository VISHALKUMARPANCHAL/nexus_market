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
        $parentnodeid = $data['parentnode_id'];
        unset($data['parentnode_id']);
        if ($parentnodeid != 1) {
            $commentId = Mage::getModel('ticket/comment')
                ->getCollection()
                ->addFieldToFilter('ticket_id', $data['ticket_id'])
                ->addFieldToFilter('node_id', $parentnodeid)
                ->getFirstItem()
                ->getCommentId();
            $data['parent_id'] = $commentId;
        }
        $a = Mage::getModel('ticket/comment')
            ->setData($data)
            ->save();
        Mage::log($a);
    }
    public function viewAction()
    {
        $id = $this->getRequest()->getQuery('id');
        $view = $this->getLayout()->createBlock('admin/ticket_index_view');
        $this->getLayout()->getChild('content')->addChild('view', $view);
        // $this->getLayout()->getChild('head')->addJs('page/admin/ticket/index/view.js');
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