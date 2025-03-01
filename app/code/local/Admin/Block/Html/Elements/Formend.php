<?php
class Admin_Block_Html_Elements_Formend
{
    protected $_data = [];
    public function __construct($data)
    {
        $this->_data = $data;
    }
    public function render()
    {
        $html = "</form>";
        return $html;
    }
}
