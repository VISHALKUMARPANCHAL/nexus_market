<?php
class Admin_Controller_Ticket_Index extends Admin_Block_Widget_Grid
{
    public function listAction()
    {
        $list = $this->getLayout()->createBlock('admin/ticket_index_list');
        $this->getLayout()->getChild('content')->addChild('list', $list);
        $this->getLayout()->toHtml();
    }
}