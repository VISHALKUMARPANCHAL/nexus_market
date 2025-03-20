<?php
class Customer_Controller_Account extends Core_Controller_Customer_Action
{
    // login
    // logout
    // registrtion
    // changepas
    // forgtpas
    protected $_allowedActions = [
        "login",
        "validate",
        "registration"
    ];
    public function dashboardAction()
    {
        $layout = Mage::getBlock('core/layout');
        $index = $layout->createBlock('customer/account_dashboard');
        $layout->getChild('content')->addChild('index', $index);
        $layout->toHtml();
    }
    public function registrationAction()
    {
        $layout = Mage::getBlock('core/layout');
        $registration = $layout->createBlock('customer/account_registration');
        $layout->getChild('content')
            ->addChild('registration', $registration);
        $layout->toHtml();
    }

    public function loginAction()
    {
        $layout = Mage::getBlock('core/layout');
        $login = $layout->createBlock('customer/account_login');
        $layout->getChild('content')->addChild('login', $login);
        $layout->toHtml();
    }
    public function logoutAction()
    {
        $session = Mage::getSingleton('core/session');
        if ($session->get('customer_id')) {
            $session->remove('customer_id');
        }
        $this->redirect('customer/account/login');
    }
    public function validateAction()
    {
        $session = Mage::getSingleton('core/session');
        $credencials = $this->getRequest()->getParams();
        $customer = Mage::getModel('customer/account')->load($credencials['email'], 'email');
        if (
            $customer->getEmail() === $credencials['email'] &&
            password_verify($credencials['password'], $customer->getPasswordHash())
        ) {
            $session->set('customer_id', $customer->getCustomerId());
            $this->redirect('customer/account/dashboard');
        } else {
            $session->remove('customer_id');
            $this->redirect('customer/account/login');
        }
    }
    public function saveAction()
    {
        $customerData = $this->getRequest()->getParam('customer_account');
        $customerData['password_hash'] = password_hash($customerData['password'], PASSWORD_DEFAULT);
        unset($customerData['password']);
        $customerId = Mage::getModel('customer/account')
            ->setData($customerData)
            ->save()
            ->getCustomerId();
        $session = Mage::getSingleton('core/session');
        if ($customerData) {
            $session->set('customer_id', $customerId);
            $this->redirect('customer/account/dashboard ');
        } else {
            $this->redirect('customer/account/registration');
        }
    }
}