<?php
class Core_Controller_Admin_Action extends Core_Controller_Front_Action
{
    protected $_allowedActions = [];
    public function __construct()
    {
        $this->_init();
    }
    protected function _init()
    {
        $islogin = $this->getSession()->get('login');
        if (!in_array($this->getRequest()->getActionName(), $this->_allowedActions)) {
            if ($islogin === 1) {
            } else {
                $this->redirect('admin/account/login');
            }
        }
    }
    public function getLayout()
    {
        return Mage::getBlock('core/layout_admin');
    }
}