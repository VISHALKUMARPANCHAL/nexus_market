<?php
class Admin_Controller_Sales_Order extends Core_Controller_Admin_Action
{
    public function indexAction()
    {
        $new = $this->getLayout()->createBlock('admin/sales_order_index');
        $this->getLayout()->getChild('content')->addChild('new', $new);
        $this->getLayout()->getChild('head')->addCss("page/admin/sales/order/index.css");
        $this->getLayout()->toHtml();
    }
    public function viewAction()
    {
        $orderId = $this->getRequest()->getQuery('id');
        $order = Mage::getModel('sales/order')
            ->load($orderId);

        $view = $this->getLayout()
            ->createBlock('admin/sales_order_view')
            ->setOrder($order);

        $this->getLayout()->getChild('head')
            ->addCss("page/admin/sales/order/view.css");

        $this->getLayout()->getChild("content")
            ->addChild("view", $view);

        $orderinfo = $this->getLayout()
            ->createBlock('admin/sales_order_view_orderinfo');
        $view->addChild("orderinfo", $orderinfo);

        $iteminfo = $this->getLayout()
            ->createBlock('admin/sales_order_view_iteminfo');
        $view->addChild("iteminfo", $iteminfo);

        $addressinfo = $this->getLayout()
            ->createBlock('admin/sales_order_view_addressinfo');
        // $view->addChild("addressinfo", $addressinfo);
        // Mage::log($this->getLayout());

        $this->getLayout()->getChild('head')
            ->addCss("page/admin/sales/order/view.css");

        $this->getLayout()->getChild("content")
            ->addChild("view", $view);
        // Mage::log($this->getLayout());
        $this->getLayout()->toHtml();
    }
    public function updatestatusAction()
    {
        $data = $this->getRequest()->getParams();
        Mage::getModel('sales/order')->setData($data)->save();
        $this->redirect('admin/sales_order/index');
    }
}
