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
        $pdata['sku'] = "{$pdata['category_id']}{$pdata['name']}";

        $product = Mage::getModel('catalog/product')
            ->load($pdata['product_id'])
            ->setData($pdata);
        // echo '<pre>';
        // print_r($product);
        // echo '</pre>';

        // echo '<pre>';
        // print_r($product);
        // print_r($_FILES);
        // echo '</pre>';
        $product->save();
        // die;
        // $pid = $product->getProductId();
        // die;
        // $attr = $request->getParam('catalog_product_attribute');
        // $product->setData($pdata);

        // $pid = $product->save()->getProductId();
        // $pid = 91;
        // $attributetable = Mage::getModel('catalog/product_attribute');
        // echo '<pre>';
        // print_r($pid);
        // echo '</pre>';
        // die;
        // $valueId = $attributetable->getCollection()->addFieldToFilter('product_id', $pid)->getData();
        // echo '<pre>';
        // print_r($valueId->getData());
        // print_r($attr);
        // echo '</pre>';
        // die;
        // $ct = 0;
        // echo '<pre>';
        // print_r($valueId);
        // print_r($attr);
        // echo '</pre>';
        // foreach ($product as $key => $value) {
        //     if (!empty($valueId)) {
        //         $value['value_id'] = $valueId[$ct]->getValueId();
        //     }
        //     // $value['product_id'] = $pid;
        //     $value['attribute_id'] = $key;
        //     $attributetable->setData($value);
        //     // print_r($attributetable);
        //     // die;
        //     $attributetable->save();
        //     $ct++;
        // }
        // die;
        // $ct = 0;
        // $images = Mage::getModel('catalog/media_gallery');
        // $imageData = [];
        // if (!empty($_FILES['catalog_media_gallery']['name']['img'][0])) {
        //     foreach ($_FILES['catalog_media_gallery']['name']['img'] as $key => $value) {
        //         if (move_uploaded_file($_FILES['catalog_media_gallery']['tmp_name']['img'][$key], "media/product/$value")) {
        //             $imageData['product_id'] = $pid;
        //             $imageData['file_path'] = "media/product/$value";
        //             $type = $_FILES['catalog_media_gallery']['type']['img'][$key];
        //             $imageData['type'] = substr($type, '0', strpos($type, '/'));
        //             $images->setData($imageData);
        //             if ($value === $request->getParam('main_Image')) {
        //                 $images->setMainImage(1);
        //             }
        //             $images->save();
        //         }
        //     }
        // }
        // $deleteimg = $request->getParam('deletedimg');
        // if ($deleteimg != "") {
        //     $gallery = Mage::getModel('catalog/media_gallery');
        //     foreach ($deleteimg as $img) {
        //         $mediaid = $gallery->getCollection()->addFieldToFilter('product_id', $pid)->addFieldToFilter('file_path', $img)->getData()[0]->getMediaId();

        //         if (file_exists($img)) {
        //             unlink($img);
        //         }
        //         $gallery->setData($mediaid);
        //         $gallery->delete();
        //     }
        // }
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
        echo '123';
        $filter = Mage::getSingleton('catalog/filter');
        $filter->getCollection();
        echo '<pre>';
        print_r($filter->prepareQuery());
        echo '</pre>';
        // $layout = Mage::getBlock('core/layout');
        // $test = $layout->createBlock('admin/product_index_test')
        //     ->setTemplate('admin/product/index/test.phtml');
        // $layout->getChild('content')->addChild('test', $test);
        // $layout->toHtml();
    }
}