<?php
class Admin_Controller_Product_Index extends Core_Controller_Admin_Action
{
    public function newAction()
    {
        $layout = Mage::getBlock('core/layout');
        $new = $layout->createBlock('admin/product_index_new')
            ->setTemplate('admin/product/index/new.phtml');
        $layout->getChild('content')->addChild('new', $new);
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
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';
        // die;
        $request = $this->getRequest();
        $pdata = $request->getParam('catalog_product');
        $name = str_replace(' ', '', strtoupper(substr($pdata['name'], 0, 5)));
        $pdata['sku'] = "{$pdata['category_id']}{$name}";
        // echo '<pre>';
        // print_r($pdata);
        // echo '</pre>';
        // die;
        $product = Mage::getModel('catalog/product')
            ->load($pdata['product_id'])
            ->setData($pdata);
        $product->save();
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

    /* for testing purpose only */
    public function testAction()
    {
        // echo '123';
        $filter = Mage::getSingleton('catalog/filter');
        $filter->getCollection();
        // echo '<pre>';
        // print_r($filter->prepareQuery());
        // echo '</pre>';
        // $layout = Mage::getBlock('core/layout');
        // $test = $layout->createBlock('admin/product_index_test')
        //     ->setTemplate('admin/product/index/test.phtml');
        // $layout->getChild('content')->addChild('test', $test);
        // $layout->toHtml();
    }
}