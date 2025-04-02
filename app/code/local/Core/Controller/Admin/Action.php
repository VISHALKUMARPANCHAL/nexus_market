<?php
class Core_Controller_Admin_Action extends Core_Controller_Front_Action
{
    protected $_allowedActions = [];
    protected $_roleAllowedActions = [];
    public function __construct()
    {
        $this->_init();
    }
    protected function _init()
    {
        $adminId = $this->getSession()->get('admin_id');
        if (!in_array($this->getRequest()->getActionName(), $this->_allowedActions)) {
            if ($adminId != 0) {
                $role_id = Mage::getModel('admin/user')->load($adminId)->getRoleId();
                $role = Mage::getModel('admin/role')->load($role_id);
                $this->getSession()->set('role_id', $role->getRoleId());
                $this->_roleAllowedActions = $role->getPermissions();
            } else {
                $this->redirect('admin/account/login');
            }
        }
    }
    public function getLayout()
    {
        return Mage::getBlockSingleton('core/layout_admin');
    }
}