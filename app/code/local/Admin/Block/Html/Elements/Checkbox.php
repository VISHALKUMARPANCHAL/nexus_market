<?php
class Admin_Block_Html_Elements_Checkbox
{
    protected $_data = [];
    public function __construct($data)
    {
        $this->_data = $data;
    }
    public function render()
    {
        $html = "<input type='checkbox' ";
        if (isset($this->_data["id"])) {
            $html .= sprintf('id = "%s"', $this->_data['id']);
        }
        if (isset($this->_data["class"])) {
            $html .= sprintf(' class = "%s"', $this->_data['class']);
        }
        if (isset($this->_data["name"])) {
            $html .= sprintf(' name = "%s"', $this->_data['name']);
        }
        if (isset($this->_data["value"])) {
            $html .= sprintf(' value = "%s"', $this->_data['value']);
        }
        if (isset($this->_data["selected"])) {
            if ($this->_data["selected"] == "yes") {
                $html .= sprintf(' selected');
            }
        }
        $html .= "/>";
        // die;
        return $html;
    }
}