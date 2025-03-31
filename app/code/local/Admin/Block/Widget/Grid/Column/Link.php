<?php
class Admin_Block_Widget_Grid_Column_Link extends Admin_Block_Widget_Grid_Column_Abstract
{
    public function render()
    {
        $getUrl = $this->getData()['callback'];
        return "<a href='{$this->getList()->$getUrl($this->getRow())}'>{$this->getData()['lable']}</a>";
    }
}