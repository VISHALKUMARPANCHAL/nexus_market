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
    public function getReviews()
    {
        $product_id = $this->getRequest()->getQuery('id');
        return Mage::getModel('catalog/product_review')
            ->getCollection()
            ->join('customer_account', "customer_account.customer_id=main_table.customer_id", ['fn' => "first_name", 'ln' => "last_name"])
            ->addFieldToFilter('product_id', $product_id)
            ->orderBy(['created_at DESC'])
            ->getData();
    }
}
