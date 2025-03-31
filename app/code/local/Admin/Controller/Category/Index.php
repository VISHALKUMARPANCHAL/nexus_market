<?php

class Admin_Controller_Category_Index extends Core_Controller_Admin_Action
{
    public function newAction()
    {
        $new = $this->getLayout()->createBlock('admin/category_index_new');
        $this->getLayout()->getChild('content')->addChild('new', $new);
        $this->getLayout()->toHtml();
    }
    public function listAction()
    {
        $list = $this->getLayout()->createBlock('admin/category_index_list');
        // ->setTemplate('admin/category/index/list.phtml');
        $this->getLayout()->getChild('content')->addChild('list', $list);
        $this->getLayout()->toHtml();
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
        $product->setCategoryId($productId);
        $product->delete();
        $this->redirect('admin/category_index/list');
    }
}