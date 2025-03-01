<?php
class Catalog_Model_Product extends Core_Model_Abstract
{
    public $status = [
        '0' => "Disable",
        '1' => "Enable"
    ];
    public function init()
    {
        $this->_resourceClassName = 'Catalog_Model_Resource_Product';
        $this->_collectionClass = 'Catalog_Model_Resource_Product_Collection';
    }
    public function getStatusText()
    {
        if (isset($this->status[$this->getStatus()])) {
            return $this->status[$this->getStatus()];
        } else {
            return "NA";
        }
    }
    protected function _afterLoad()
    {
        if ($this->getProductId()) {
            $collection = Mage::getModel("catalog/product_attribute")
                ->getcollection()
                ->addFieldToFilter("product_id", $this->getProductId())
                ->leftJoin(
                    ["attr" => "catalog_attribute"],
                    "attr.attribute_id = main_table.attribute_id",
                    ["name" => "name"]
                );
            $collection2 = Mage::getModel("catalog/media_gallery")
                ->getcollection()
                ->addFieldToFilter("main_table.product_id", $this->getProductId());
            // echo "<pre>";
            // print_r($collection->getData());
            // echo "</pre>";
            // echo "<pre>";
            // print_r($collection2->getData());
            // echo "</pre>";
            foreach ($collection->getData() as $_data) {
                $this->{$_data->getName()} = $_data->getValue();
            }
            $file_path = [];
            foreach ($collection2->getData() as $_data) {
                $file_path[] = $_data->getFilePath();
            }
            $this->_data['file_path'] = $file_path;
            // echo "<pre>";
            // print_r($collection->getData());
            // echo "</pre>";
        }
        return $this;
    }
}
