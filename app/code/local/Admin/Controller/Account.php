<?php
class Admin_Controller_Account extends Core_Controller_Admin_Action
{
    protected $_allowedActions = [
        "login",
        "loginPost"
    ];
    public function loginAction()
    {
        $login = $this->getLayout()->createBlock('admin/account_login')
            ->setTemplate('admin/account/login.phtml');
        $this->getLayout()->getChild('content')->addChild('login', $login);
        $this->getLayout()->toHtml();
    }
    public function loginPostAction()
    {
        $session = Mage::getSingleton('core/session');
        $params = $this->getRequest()->getParams();
        $admin = Mage::getSingleton('admin/user')->load($params['username'], 'username');
        // Mage::log($admin);

        if ($admin->getUsername() == $params['username'] && $admin->getPasswordHash() == $params['password']) {
            $session->set('admin_id', $admin->getAdminId());
            $this->redirect('admin/dashboard/index');
        } else {
            $session->remove('login');
            $this->redirect('admin/account/login');
        }
    }
    public function logoutAction()
    {
        $session = Mage::getSingleton('core/session');
        if ($session->get('admin_id')) {
            $session->remove('admin_id');
        }
        $this->redirect('admin/account/login');
    }
}
