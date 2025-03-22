<?php
class Admin_Controller_Dashboard extends Core_Controller_Admin_Action
{
    public function indexAction()
    {
        $index = $this->getLayout()->createBlock('admin/Dashboard_Index')
            ->setTemplate('admin/dashboard/index.phtml');
        $this->getLayout()->getChild('content')->addChild('index', $index);
        $this->getLayout()->toHtml();
    }
}