<?php
class Admin_Block_Category_Index_Test extends Core_Block_Template
{


    public function getHtmlField($field, $data)
    {
        $field = ucfirst(strtolower($field));
        $className = sprintf("Admin_Block_Html_Elements_%s", $field);
        $element = new $className($data);
        return $element->render();
    }
}
