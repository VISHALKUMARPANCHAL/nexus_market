<?php
class Admin_Controller_Index extends Core_Controller_Admin_Action
{
    public function indexAction()
    {
        $layout = Mage::getBlock('core/layout');
        $index = $layout->createBlock('admin/index_Index')
            ->setTemplate('admin/index/index.phtml');
        $layout->getChild('content')->addChild('index', $index);
        $layout->toHtml();
    }
}