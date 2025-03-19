<?php
class Customer_Controller_Account extends Core_Controller_Front_Action
{
    // login
    // logout
    // registrtion
    // changepas
    // forgtpas
    public function registrationAction()
    {
        $layout = Mage::getBlock('core/layout');
        $registration = $layout->createBlock('customer/account_registration');
        $layout->getChild('content')->addChild('registration', $registration);
        $layout->toHtml();
    }
    public function saveAction()
    {
        $customerData = $this->getRequest()->getParam('customer_account');
        Mage::log($customerData);
        $customer = Mage::getModel('customer/account')->setData($customerData)->save();
        Mage::log($customer);
    }
}