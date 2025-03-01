<?php
class Admin_Block_Html_Elements_Date
{
    protected $_data = [];
    public function __construct($data)
    {
        $this->_data = $data;
    }
    public function render()
    {
        $html = "<input type='date' ";
        if (isset($this->_data["id"])) {
            $html .= sprintf('id = "%s"', $this->_data['id']);
        }
        if (isset($this->_data["class"])) {
            $html .= sprintf(' class = "%s"', $this->_data['class']);
        }
        if (isset($this->_data["name"])) {
            $html .= sprintf(' name = "%s"', $this->_data['name']);
        }
        if (isset($this->_data["placeholder"])) {
            $html .= sprintf(' placeholder = "%s"', $this->_data['placeholder']);
        }
        if (isset($this->_data["value"])) {
            $html .= sprintf(' value = "%s"', $this->_data['value']);
        }
        $html .= "/>";
        // die;
        return $html;
    }
}