<?php
class Admin_Block_Widget_Grid_Column_Abstract
{
    protected $_data;
    protected $_row;
    protected $_list;
    public function render()
    {
        return "<span>{$this->getValue()}</span>";
    }
    public function getValue()
    {
        return $this->_row->{$this->_data['data_index']};
    }
    public function setRow($row)
    {
        $this->_row = $row;
        return $this;
    }
    public function getRow()
    {
        return $this->_row;
    }
    public function setData($data)
    {
        $this->_data = $data;
        return $this;
    }
    public function getData()
    {
        return $this->_data;
    }
    public function setList($list)
    {
        $this->_list = $list;
        return $this;
    }
    public function getList()
    {
        return $this->_list;
    }
    public function getFilter()
    {
        if (isset($this->getData()['filter'])) {
            return Mage::getBlock("Admin/widget_grid_filter_{$this->getData()['filter']}");
        } else {
            return Mage::getBlock("Admin/widget_grid_filter_Abstract");
        }
    }
}