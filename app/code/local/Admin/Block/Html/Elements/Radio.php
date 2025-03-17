<?php
class Admin_Block_Html_Elements_Radio
{
    protected $_data = [];
    public function __construct($data)
    {
        $this->_data = $data;
    }
    public function render()
    {
        $html = "<input type='radio' ";
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
        if (isset($this->_data["checked"])) {
            if ($this->_data["checked"] == "yes") {
                $html .= sprintf(' checked');
            }
        }
        $html .= "/>";
        // die;
        return $html;
    }
}