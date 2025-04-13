<?php
class Admin_Block_Dashboard_Index extends Core_Block_Template
{
    public function getAllowedPermission($args)
    {
        $role = Mage::getModel('admin/user_session')->getRole();
        $argArr = explode('/', $args);
        $permission = json_decode($role->getPermissions(), true);
        $key = $argArr[0];
        $value = $argArr[1];
        if (isset($permission[$key]) && in_array($value, $permission[$key])) {
            return true;
        } else {
            return false;
        }
    }
    public function getName()
    {
        $aid = Mage::getSingleton('core/session')
            ->get('admin_id');
        return Mage::getModel('admin/user')
            ->load($aid)
            ->getUsername();
    }
}