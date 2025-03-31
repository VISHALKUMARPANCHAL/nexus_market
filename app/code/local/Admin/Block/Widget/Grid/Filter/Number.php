<?php
class Admin_Block_Widget_Grid_Filter_Number extends Core_Block_Template
{
    public function render()
    {
        return "<input type='number' placeholder='from'><input type='number' placeholder='to'>";
    }
}