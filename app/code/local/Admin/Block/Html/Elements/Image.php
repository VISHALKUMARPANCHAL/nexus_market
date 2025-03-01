<?php
class Admin_Block_Html_Elements_Image
{
    protected $_data = [];
    public function __construct($data)
    {
        $this->_data = $data;
    }
    public function render()
    {
        $html = "<img ";
        if (isset($this->_data["src"])) {
            $html .= sprintf('src = "%s"', $this->_data['src']);
        }
        if (isset($this->_data["alt"])) {
            $html .= sprintf(' alt = "%s"', $this->_data['alt']);
        }
        if (isset($this->_data["width"])) {
            $html .= sprintf(' width = "%s"', $this->_data['width']);
        }
        if (isset($this->_data["height"])) {
            $html .= sprintf(' height = "%s"', $this->_data['height']);
        }
        $html .= "/>";
        // die;
        return $html;
    }
}
