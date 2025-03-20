<?php
class Admin_Controller_Order extends Core_Controller_Admin_Action
{
    public function indexAction()
    {
        $layout = $this->getLayout();
        $new = $layout->createBlock('admin/sales_order_index');
        $layout->getChild('content')->addChild('new', $new);
        $layout->getChild('head')->addCss("page/admin/sales/order/index.css");
        $layout->toHtml();
    }
    public function viewAction()
    {
        $orderId = $this->getRequest()->getQuery('id');
        $order = Mage::getModel('sales/order')
            ->load($orderId);
        $layout = $this->getLayout();

        $view = $layout
            ->createBlock('admin/sales_order_view')
            ->setOrder($order);

        $orderinfo = $layout
            ->createBlock('admin/sales_order_view_orderinfo');
        // ->setOrderBlock($view);

        $iteminfo = $layout
            ->createBlock('admin/sales_order_view_iteminfo');
        // ->setOrderBlock($view);

        $addressinfo = $layout
            ->createBlock('admin/sales_order_view_addressinfo');
        // ->setOrderBlock($view);


        $layout->getChild("content")
            ->addChild("view", $view);
        $layout->getChild('head')
            ->addCss("page/admin/sales/order/view.css");
        $layout->getChild("content")
            ->getChild("view")
            ->addChild("orderinfo", $orderinfo);
        $layout->getChild("content")
            ->getChild("view")
            ->addChild("iteminfo", $iteminfo);
        $layout->getChild("content")
            ->getChild("view")
            ->addChild("addressinfo", $addressinfo);
        // Mage::log($layout);
        $layout->toHtml();
    }
}