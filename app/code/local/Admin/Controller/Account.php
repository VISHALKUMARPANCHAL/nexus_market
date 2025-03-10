<?php
class Admin_Controller_Account extends Core_Controller_Admin_Action
{
    protected $_allowedActions = [
        "login",
        "loginPost"
    ];
    public function loginAction()
    {
        // echo 'hello';
        // $session = Mage::getSingleton('core/session');
        $layout = Mage::getBlock('core/layout');
        $login = $layout->createBlock('admin/account_login')
            ->setTemplate('admin/account/login.phtml');
        $layout->getChild('content')->addChild('login', $login);
        $layout->toHtml();

        // var_dump($session->getId());
        // var_dump($session->getId());
        // $session->remove('k');

        // echo '<pre>';
        // print_r($_SESSION);
        // echo '</pre>';

    }
    public function loginPostAction()
    {
        $session = Mage::getSingleton('core/session');
        $params = $this->getRequest()->getParams();
        // echo '<pre>';
        // print_r($params);
        // echo '</pre>';
        // die;
        $admin = Mage::getSingleton('admin/user')->load($params['username'], 'username');
        // echo '<pre>';
        // print_r($admin);
        // echo '</pre>';
        if ($admin->getUsername() == $params['username'] && $admin->getPasswordHash() == $params['password']) {
            // echo 'yes';
            // die;
            $session->set('login', 1);
            $this->redirect('admin');
        } else {
            $session->remove('login');
            $this->redirect('admin/account/login');
        }
        // echo '<pre>';
        // print_r($params);
        // echo '</pre>';
    }
    public function logoutAction()
    {
        $session = Mage::getSingleton('core/session');
        // $session->remove('login');
        // echo '<pre>';
        // print_r(session_status());
        // echo '</pre>';
        // die;
        // echo '123';
        // echo '<pre>';
        // print_r($session->get('login'));
        // echo '</pre>';
        // die;

        if ($session->get('login')) {
            $session->remove('login');
        }
        $this->redirect('admin/account/login');
    }
}
