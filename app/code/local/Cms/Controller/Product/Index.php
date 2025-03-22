<?php
class Cms_Controller_Product_index extends Core_Controller_Front_Action
{
    public function listAction()
    {
        $layout = Mage::getBlock('core/layout');
        $list = $layout->createBlock('cms/product_index_list')
            ->setTemplate('cms/product/index/list.phtml');
        $layout->getChild('content')->addChild('list', $list);
        $layout->toHtml();
    }
}