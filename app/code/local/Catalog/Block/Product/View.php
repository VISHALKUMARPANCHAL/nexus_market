<?php
class Catalog_Block_Product_View extends Core_Block_Template
{

    public function __construct()
    {
        $this->setTemplate('catalog/product/view.phtml');
    }
    public function getProductdata()
    {
        $request = Mage::getModel('core/request');
        $data = Mage::getModel("catalog/product")
            ->load($request->getQuery('id'));
        return $data;
    }
}
