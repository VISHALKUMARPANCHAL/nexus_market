<?php
class Admin_Block_Widget_Grid_Filter_Text extends Admin_Block_Widget_Grid_Filter_Abstract
{
    public function render()
    {
        // $placeholder = $this->getData()['lable'];
        return "<input type='text' placeholder='search' name='{$this->getData()['data_index']}'>";
        // return 1;
    }
}
