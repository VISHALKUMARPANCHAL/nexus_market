<?php
class Core_Controller_Front
{
    public function init()
    {
        $request = Mage::getModel("core/request");
        $controller = ucwords(sprintf("%s_Controller_%s", $request->getModuleName(), $request->getControllerName()), '_');
        $obj = new $controller();
        $action = $request->getActionName() . 'Action';
        $obj->$action();
    }
}