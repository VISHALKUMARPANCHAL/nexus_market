<?php
class Catalog_Model_Resource_Product_Collection extends Core_Model_Resource_Collection_Abstract
{

    public function addAttributeToSelect($attributes)
    {

        foreach ($attributes as $attribute) {

            $a = Mage::getModel("catalog/attribute")
                ->load($attribute, "name");
            $attribute_id = $a->getAttributeId();
            $this->leftJoin(
                ["cpa_{$a->getName()}" => "catalog_product_attribute"],
                "main_table.product_id=cpa_{$a->getName()}.product_id AND cpa_{$a->getName()}.attribute_id={$attribute_id}",
                ["{$a->getName()}" => "value"]
            );
        }
        return $this;
    }
}
