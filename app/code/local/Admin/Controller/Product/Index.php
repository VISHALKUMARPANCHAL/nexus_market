<?php
class Admin_Controller_Product_Index extends Core_Controller_Admin_Action
{
    public function newAction()
    {
        $new = $this->getLayout()->createBlock('admin/product_index_new')
            ->setTemplate('admin/product/index/new.phtml');
        $this->getLayout()->getChild('content')->addChild('new', $new);
        $this->getLayout()->getChild('head')->addJs('page/admin/product/new.js', $new);
        $this->getLayout()->toHtml();
    }
    public function listAction()
    {
        $list = $this->getLayout()->createBlock('admin/product_index_list')
            ->setTemplate('admin/product/index/list.phtml');
        $this->getLayout()->getChild('content')->addChild('list', $list);
        $this->getLayout()->toHtml();
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
        $product->setProductId($productId);
        $product->delete();
        $this->redirect('admin/product_index/list');
    }
    public function testAction()
    {
        $filter = Mage::getSingleton('catalog/filter');
        $filter->getCollection();
    }
}