<?php
class Reply_Controller_Comment extends Core_Controller_Front_Action
{
    public function viewAction()
    {
        $view = $this->getLayout()->createBlock('reply/comment_view');
        $this->getLayout()->getChild('content')->addChild('view', $view);
        $this->getLayout()->toHtml();
    }
    public function saveAction()
    {
        $data = $this->getRequest()->getParams();
        // Mage::log($data);
        // die;
        $title = $data['title'];
        $parent_id = $data['parent_id'];
        $comment = Mage::getModel('reply/comment')
            ->setTitle($title)
            ->setParentId($parent_id)
            ->save();
        // Mage::log($comment);
    }
}