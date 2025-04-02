<?php
class Admin_Block_Widget_Grid_Column_Dropdown extends Admin_Block_Widget_Grid_Column_Abstract
{
    public function render()
    {
        $options = "";
        foreach ($this->getData()['options'] as $option) {
            $options .= "<option value='$option'>{$option}</option>";
        }
        return "<form><select>{$options}</select></form>";
        // return "<form><select class='w-custom'>{$options}</select><form>";
    }
}
