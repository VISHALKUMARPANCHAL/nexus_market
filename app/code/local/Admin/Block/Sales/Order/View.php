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
        if (isset($this->_order)) {
            return $this->_order;
        }
    }

    public function getSubtotal()
    {
        $data = $this->getOrder()->getItemCollection()->getData();
        $subTotal = 0;
        if ($data) {
            foreach ($data as $_data) {
                $subTotal += $_data->getSubTotal();
            }
        }
        return $subTotal;
    }
}
