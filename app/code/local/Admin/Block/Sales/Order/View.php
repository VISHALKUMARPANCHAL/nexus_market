<?php
class  Admin_Block_Sales_Order_View extends Core_Block_Template
{
    protected $_order = null;
    public function __construct()
    {
        $this->_template = 'admin/sales/order/view.phtml';
    }
    public function setOrder($order)
    {
        $this->_order = $order;
        return $this;
    }
    public function getOrder()
    {
        return $this->_order;
    }
    public function getSubtotal()
    {
        $data = $this->getOrder();
        return ($data->getTotalAmount() + $data->getCouponDiscount() - $data->getShippingPrice());
    }
}