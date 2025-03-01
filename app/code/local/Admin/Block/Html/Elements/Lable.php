<?php
class Admin_Block_Html_Elements_Lable
{
    protected $_data = [];
    public function __construct($data)
    {
        $this->_data = $data;
    }
    public function render()
    {
        $html = "<label ";
        if (isset($this->_data["for"])) {
            $html .= sprintf('for = "%s" >', $this->_data['for']);
        }
        if (isset($this->_data["value"])) {
            $html .= sprintf('%s', $this->_data['value']);
        }
        $html .= "</label>";
        // die;
        return $html;
    }
}
