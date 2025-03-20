<?php
class Customer_Controller_Account_Address extends Core_Controller_Front_Action
{
    public function indexAction()
    {
        $layout = Mage::getBlock('core/layout');
        $address = $layout->createBlock('customer/account_address_index');
        $layout->getChild('content')->addChild('address', $address);
        $layout->toHtml();
    }
    public function deleteAction()
    {
        $id = $this->getRequest()->getQuery('id');
        Mage::getModel('customer/account_address')
            ->setAddressId($id)
            ->delete();
        $this->redirect('customer/account/dashboard');
    }
    public function saveAction()
    {
        $customerData = $this->getRequest()->getParam('customer_account_address');
        $customerData['customer_id'] = Mage::getSingleton('core/session')->get('customer_id');
        Mage::getModel('customer/account_address')
            ->setData($customerData)
            ->save();
        $this->redirect('customer/account/dashboard');
    }
}