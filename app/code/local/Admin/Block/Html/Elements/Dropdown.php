<?php
class Admin_Block_Html_Elements_Dropdown
{
    protected $_data = [];
    public function __construct($data)
    {
        $this->_data = $data;
    }
    public function render()
    {
        $html = "<select ";
        if (isset($this->_data["id"])) {
            $html .= sprintf('id = "%s"', $this->_data['id']);
        }
        if (isset($this->_data["class"])) {
            $html .= sprintf(' class = "%s"', $this->_data['class']);
        }
        if (isset($this->_data["name"])) {
            $html .= sprintf(' name = "%s"', $this->_data['name']);
        }

        $html .= ">";



        if (isset($this->_data["options"])) {
            foreach ($this->_data['options'] as $data => $value) {
                if ($value == 'default') {
                    $html .= sprintf('<option value="" selected dissable hidden>%s</option>', $data);
                } else {
                    $html .= sprintf('<option value="%s">%s</option>', $value, $data);
                }
            }
        }


        $html .= '</select>';

        return $html;
    }
}