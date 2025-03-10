<?php
class Catalog_Controller_Product
{
    public function viewAction()
    {
        // $product = Mage::getModel('catalog/product');

        $layout = Mage::getBlock('core/layout');
        $view = $layout->createBlock('catalog/product_view');
        $layout->getChild('content')->addChild('view', $view);
        // print_r($layout->getChild('content'));
        $layout->toHtml();
    }
    public function listAction()
    {
        $layout = Mage::getBlockSingleton('core/layout');
        // if (0) {
        //     $layout->removeChild('header');
        // }
        $list = $layout->createBlock('catalog/product_list')
            ->setTemplate('catalog/product/list.phtml');
        $layout->getChild('content')->addChild('list', $list);
        $layout->toHtml();
    }
    public function testAction()
    {
        $filter = Mage::getModel('catalog/filter')->getProductCollection();
        // echo '<pre>';
        // print_r($filter->prepareQuery());
        // echo '</pre>';
        // $collections = Mage::getModel("catalog/product")
        //     ->getcollection()
        //     ->addAttributeToSelect(["series", "material", "weight"]);
        // ->load("41");
        // ->limit(5);
        // echo "<pre>";
        // print_r($collections->getData());
        // echo "</pre>";

        // ->getCollection()
        // ->addAttributeToSelect(["material", "weight"]);

        // ->limit(5);
        // print_r($collection->getData());
        // echo '</pre>';
        // $product = Mage::getModel('catalog/product');
        // $product->load(37)->getData();
        // echo "<pre>";
        // print_r($product);
        // $product = Mage::getModel('catalog/product');
        // print_r($product);
        // $product = Mage::getSingleton('catalog/product');
        // $product->load(37)->getData();
        // $product2 = Mage::getSingleton('catalog/product');
        // print_r($product);
        // print_r($product2);
        // $product2->setName('123');
        // echo $product->getName();
        // print_r($product);


        // ->getCollection()
        // ->addFieldToFilter('product_id', ['<' => 40])
        // ->addFieldToFilter('product_id', ['IN' => [2, 3, 4]])
        // ->leftJoin('catlog_category', 'catlog_category.category_id = catlog_product.category_id', ['category_name' => 'name'])
        // ->rightJoin('catlog_category', 'catlog_category.category_id = catlog_product.category_id', ['category_name' => 'name']);
        // ->innerJoin('catlog_category', 'catlog_category.category_id = catlog_product.category_id', ['category_name' => 'name']);
        // ->join('catlog_category', 'catlog_category.category_id = catlog_product.category_id', ['category_name' => 'name']);
        // ->fullJoin('catlog_category', ['category_name' => 'name']);
        // ->selfJoin(['A', 'B'], ['name' => 'A.name', 'pr' => 'B.price']);
        // ->crossJoin('catlog_category', ['category_name' => 'name']);
        // ->naturalJoin('catlog_category', ['category_name' => 'name']);
        // ->groupBy(['name', 'price'])
        // ->having('COUNT(*)', ['<' => 40]);
        // ->orderBy(['product_id DESC', 'name ASC'])
        // ->limit(1, 2);
        // $product->prepareQuery();
    }
}