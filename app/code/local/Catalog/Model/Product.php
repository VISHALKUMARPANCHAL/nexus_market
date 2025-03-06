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
    protected function _afterSave()
    {
        echo '<pre>';
        print_r($this);
        echo '</pre>';

        $attributes = Mage::getModel('catalog/attribute')->getCollection()->getData();
        $request = Mage::getModel('core/request');
        foreach ($attributes as $_attribute) {
            $productAttributes = Mage::getModel('catalog/product_attribute')
                ->getCollection()
                ->addFieldToFilter('product_id', $this->getProductId())
                ->addFieldToFilter('attribute_id', $_attribute->getAttributeId())
                ->getData();
            $value = $this->{$_attribute->getName()};
            if (isset($productAttributes[0])) {
                $productAttributes[0]->setValue($value)
                    ->save();
            } else {
                Mage::getModel('catalog/product_attribute')
                    ->setAttributeId($_attribute->getAttributeId())
                    ->setProductId($this->getProductId())
                    ->setValue($value)
                    ->save();
            }
        }
        // die;
        $images = Mage::getModel('catalog/media_gallery');
        $imageData = [];
        echo '<pre>';
        print_r($_FILES);
        echo '</pre>';
        if (!empty($_FILES['catalog_product']['name']['img'][0])) {
            foreach ($_FILES['catalog_product']['name']['img'] as $key => $value) {
                if (move_uploaded_file($_FILES['catalog_product']['tmp_name']['img'][$key], "media/product/$value")) {
                    $imageData['product_id'] = $this->getProductId();
                    $imageData['file_path'] = "media/product/$value";
                    $type = $_FILES['catalog_product']['type']['img'][$key];
                    $imageData['type'] = substr($type, '0', strpos($type, '/'));
                    $images->setData($imageData);
                    if ($value === $request->getParam('main_image')) {
                        $images->setMainImage(1);
                    }
                    $images->save();
                }
            }
        }
        $deleteimg = $request->getParam('deletedimg');
        if ($deleteimg != "") {
            $gallery = Mage::getModel('catalog/media_gallery');
            foreach ($deleteimg as $img) {
                $mediaid = $gallery->getCollection()->addFieldToFilter('product_id', $this->getProductId())->addFieldToFilter('file_path', $img)->getData()[0]->getMediaId();
                if (file_exists($img)) {
                    unlink($img);
                }
                $gallery->setData($mediaid);
                $gallery->delete();
            }
        }
        // die;
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