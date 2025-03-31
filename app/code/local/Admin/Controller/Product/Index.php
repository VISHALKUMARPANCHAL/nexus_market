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
        $list = $this->getLayout()->createBlock('admin/product_index_list');
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
        $product->setProductId($productId);
        $product->delete();
        $this->redirect('admin/product_index/list');
    }
    public function testAction()
    {
        $filter = Mage::getSingleton('catalog/filter');
        $filter->getCollection();
    }
    public function importAction()
    {
        if (isset($_POST["Import"])) {
            $filename = $_FILES["file"]["tmp_name"];
            if (pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION) != "csv") {
                echo "Please upload a CSV file.";
            } else {
                $file = fopen($filename, "r");
                $columns = fgetcsv($file, 1000, ",");
                // foreach ($columns as $key => $column) {
                //     $parts = explode('_', $column);
                //     foreach ($parts as $key2 => $part) {
                //         if ($key2 > 0) {
                //             $parts[$key2] = ucfirst($part);
                //         }
                //     }
                //     $columns[$key] = implode('', $parts);
                // }
                Mage::log($columns);
                while (($csvData = fgetcsv($file, 1000, ",")) !== false) {
                    $data = array_combine($columns, $csvData);
                    $product = Mage::getModel('catalog/product');
                    $product->setData($data)->save();
                    Mage::log($product);
                }

                // echo "yes";
            }
        }
    }
}