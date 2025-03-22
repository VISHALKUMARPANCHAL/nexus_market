<?php
class Catalog_Model_Filter extends Core_Model_Abstract
{
    public function getProductCollection()
    {
        $collection = Mage::getSingleton('catalog/product')->getCollection();
        $this->applyFilter($collection);
        return $collection;
    }
    public function applyFilter($collection)
    {
        $request = Mage::getSingleton('core/request');
        $parameter = $request->getQuery();
        if (isset($parameter['id'])) {
            // $parameter['id'] = str_contains($parameter['id'], ',') ? explode(',', $parameter['id']) : $parameter['id'];
            $collection->addCategoryFilter($parameter['id']);
            unset($parameter['id']);
        }
        if (!empty($parameter)) {
            $attributes = Mage::getModel('catalog/attribute')->getcollection()
                ->addFieldToFilter('name', ["IN" => array_keys($parameter)]);

            foreach ($attributes->getData() as $attribute) {
                // if (array_key_exists()) {
                // }
                $collection->addAttributeToFilter($attribute->getName(),    $parameter[$attribute->getName()]);
            }
        }
        // echo '<pre>';
        // print_r($attributes->getData());
        // echo '</pre>';
    }
}