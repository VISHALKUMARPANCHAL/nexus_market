<?php
class Admin_Block_Html_Elements_Formstart
{
    protected $_data = [];
    public function __construct($data)
    {
        $this->_data = $data;
    }
    public function render()
    {
        $html = "<form ";
        if (isset($this->_data["method"])) {
            $html .= sprintf(' method = "%s"', $this->_data['method']);
        }
        if (isset($this->_data["action"])) {
            $html .= sprintf(' action = "%s"', $this->_data['action']);
        }
        if (isset($this->_data["id"])) {
            $html .= sprintf('id = "%s"', $this->_data['id']);
        }
        if (isset($this->_data["class"])) {
            $html .= sprintf(' class = "%s"', $this->_data['class']);
        }
        if (isset($this->_data["name"])) {
            $html .= sprintf(' name = "%s"', $this->_data['name']);
        }
        if (isset($this->_data["enctype"])) {
            $html .= sprintf(' enctype = "%s"', $this->_data['enctype']);
        }
        $html .= " >";
        // die;
        return $html;
    }
}
