<?php
class Admin_Block_Widget_Grid_Filter_Dropdown extends Admin_Block_Widget_Grid_Filter_Abstract
{
    public function render()
    {
        $options = "";
        // Mage::log($this->getData());
        // foreach ($this->getData()['  options'] as $option) {
        //     $option .= "<option value='$option'>{$option}</option>";
        // }
        return "<select>{$options}</select>";
    }
}
