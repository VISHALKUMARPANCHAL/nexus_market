<?php
class Admin_Block_Widget_Grid_Filter_Number extends Admin_Block_Widget_Grid_Filter_Abstract
{
    public function render()
    {
        return "<input type='number' placeholder='from' name='{$this->getData()['data_index']}-from'><input type='number' placeholder='to' name='{$this->getData()['data_index']}-to'>";
    }
}
