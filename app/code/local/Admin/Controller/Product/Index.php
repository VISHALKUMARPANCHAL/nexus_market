<?php
class Admin_Controller_Product_Index extends Core_Controller_Admin_Action
{
    public function newAction()
    {
        $layout = Mage::getBlock('core/layout');
        $new = $layout->createBlock('admin/product_index_new')
            ->setTemplate('admin/product/index/new.phtml');
        $layout->getChild('content')->addChild('new', $new);
        $layout->getChild('head')->addJs('page/admin/product/new.js', $new);
        $layout->toHtml();
    }
    public function listAction()
    {
        $layout = Mage::getBlock('core/layout');
        $list = $layout->createBlock('admin/product_index_list')
            ->setTemplate('admin/product/index/list.phtml');
        $layout->getChild('content')->addChild('list', $list);
        $layout->toHtml();
    }
    public function saveAction()
    {
        $request = $this->getRequest();
        $pdata = $request->getParam('catalog_product');
        $name = str_replace(' ', '', strtoupper(substr($pdata['name'], 0, 5)));
        $pdata['sku'] = "{$pdata['category_id']}{$name}";
        // Mage::log($pdata);
        $product = Mage::getModel('catalog/product')
            ->load($pdata['product_id'])
            ->setData($pdata);
        // Mage::log($product);
        $product->save();
        // die;
        $this->redirect('admin/product_index/list');
    }
    public function deleteAction()
    {
        $request = Mage::getModel('core/request');
        $product = Mage::getModel('catalog/product');
        $productId = $request->getQuery('id');
        $image = $product->load($productId)->getData()['image'];
        if (file_exists($image)) {
            unlink($image);
        }
        $product->setData($productId);
        $product->delete();
        $this->redirect('admin/product_index/list');
    }
    public function testAction()
    {
        $filter = Mage::getSingleton('catalog/filter');
        $filter->getCollection();
    }
}