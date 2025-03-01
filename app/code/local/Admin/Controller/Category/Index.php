<?php

class Admin_Controller_Category_Index extends Core_Controller_Admin_Action
{
    public function newAction()
    {
        $layout = Mage::getBlock('core/layout');
        $new = $layout->createBlock('admin/category_index_new')
            ->setTemplate('admin/category/index/new.phtml');
        $layout->getChild('content')->addChild('new', $new);
        $layout->toHtml();
    }
    public function listAction()
    {
        $layout = Mage::getBlock('core/layout');
        $list = $layout->createBlock('admin/category_index_list')
            ->setTemplate('admin/category/index/list.phtml');
        $layout->getChild('content')->addChild('list', $list);
        $layout->toHtml();
    }
    public function saveAction()
    {
        $product = Mage::getModel('catalog/category');
        $product->setData($this->getRequest()->getParam('catalog_category'));
        $product->save();
        $this->redirect('admin/category_index/list');
    }
    public function deleteAction()
    {
        $product = Mage::getModel('catalog/category');
        $productId = $this->getRequest()->getQuery('id');
        $product->setData($productId);
        $product->delete();
        $this->redirect('admin/category_index/list');
    }
}