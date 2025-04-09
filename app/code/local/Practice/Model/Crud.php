<?php
class Practice_Model_Crud extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = 'practice_model_resource_crud';
        $this->_collectionClass = 'practice_model_resource_crud_collection';
    }
}