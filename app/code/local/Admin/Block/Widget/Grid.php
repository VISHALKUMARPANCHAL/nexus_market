<?php
class Admin_Block_Widget_Grid extends Core_Block_Template
{
    protected $_collection;
    protected $_columns = [];
    public function __construct()
    {
        $this->setTemplate("admin/widget/grid.phtml");
        $toolbar = $this->getLayout()->createBlock('admin/widget_grid_toolbar');
        $export = $this->getLayout()->createBlock('admin/widget_grid_export');
        $this->addChild('toolbar', $toolbar);
        $this->addChild('export', $export);
        $this->init();
        // Mage::log($this);
    }
    public function init()
    {
        $this->getChild('toolbar')->prepareToolbar();
        $this->getChild('export')->prepareExport();
    }
    public function addColumn($key, $data)
    {
        $obj = $this->_columns[$key] = Mage::getBlock("Admin/widget_grid_column_{$data['render']}");
        $obj->setData($data);
        $obj->setList($this);
        return $this;
    }
    public function getColumns()
    {
        return $this->_columns;
    }
    public function setCollection($collection)
    {
        $this->_collection = $collection;
        return $this;
    }
    public function getCollection()
    {
        return $this->_collection;
    }
}
