<?php
class Checkout_Block_Cart_Index extends Core_Block_Template
{
    protected $_collection;

    public function __construct()
    {
        $this->setTemplate('checkout/cart/index.phtml');
        $toolbar = $this->getLayout()->createBlock('customer/grid_toolbar');
        $this->addChild('toolbar', $toolbar);
        $this->init();
    }
    public function init()
    {
        $this->_collection = Mage::getSingleton('checkout/session')
            ->getCart()
            ->getItemCollection();
        $this->getChild('toolbar')->prepareToolbar();
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    public function getItems()
    {
        return $this->getCollection()
            ->getData();
    }
    public function getCart()
    {
        return Mage::getSingleton('checkout/session')
            ->getCart();
    }
    public function getTotalAmount()
    {
        $items = $this->getItems();
        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += $item->getSubTotal();
        }
        return $totalAmount;
    }
}