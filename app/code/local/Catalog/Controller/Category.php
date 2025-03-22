<?php
class Catalog_Controller_Category
{
    public function listAction()
    {
        $layout = Mage::getBlock('core/layout');
        $list = $layout->createBlock('catalog/category_list')
            ->setTemplate('catalog/category/list.phtml');
        $layout->getChild('content')->addChild('list', $list);
        $layout->toHtml();
    }
}