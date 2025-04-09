<?php
class Practice_Controller_Crud extends Core_Controller_Front_Action
{
    public function indexAction()
    {
        $layout = Mage::getBlock('core/layout');
        $index = $layout->createBlock('practice/crud_index');
        $layout->getChild('content')->addChild('index', $index);
        $layout->toHtml();
    }
    public function saveAction()
    {
        $data = $this->getRequest()->getParam('crud');
        // Mage::log($data);
        // die;
        $data['play'] = implode(' & ', $data['play']);
        $crud = Mage::getModel('practice/crud')
            ->setData($data)
            ->save();
        // Mage::log($crud);
        // die;
        $this->redirect('practice/crud/index');
    }
    public function deleteAction()
    {
        $cid = $this->getRequest()->getQuery('cid');
        Mage::getModel('practice/crud')
            ->setCid($cid)
            ->delete();
        $this->redirect('practice/crud/index');
    }
}